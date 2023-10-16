<?php
namespace App;
use App\Util\ReflectionUtil;
use Closure;
use ReflectionException;

class App
{
    protected static ?App $instance = null;

    public static function getInstance() : ?App {
        return static::$instance;
    }

    public static function setInstance(?App $instance) : void {
        static::$instance = $instance;
    }

    protected array $bindings = [];

    protected array $sharedInstances = [];

    /**
     * @throws ReflectionException
     */
    public function __construct()
    {
        $this->setupFirstBindings();
    }

    /**
     * @throws ReflectionException
     */
    public function bind(string $abstract, Closure|string|null $concrete = null, bool $shared = false): void
    {
        if(isset($this->sharedInstances[$abstract]))
            unset($this->sharedInstances[$abstract]);

        if(!isset($concrete))
            $concrete = $abstract;

        if($concrete instanceof Closure) {
            $builder = $concrete;
            $parameters = ReflectionUtil::getClosureArguments($concrete);
        } else {
            $builder = ReflectionUtil::getObjectBuildingClosure($concrete);
            $parameters = ReflectionUtil::getClosureArguments(ReflectionUtil::getConstructor($concrete));
        }

        $this->bindings[$abstract] = [
            'builder' => $builder,
            'shared' => $shared,
            'parameters' => $parameters
        ];
    }

    public function isBound(string $abstract) : bool {
        return array_key_exists($abstract, $this->bindings);
    }

    public function sharedInstanceExists(string $abstract) : bool {
        return array_key_exists($abstract, $this->sharedInstances);
    }

    public function instance(string $abstract, mixed $instance = null) : void {
        $this->bindings[$abstract] = [
            'builder' => null,
            'shared' => true,
            'parameters' => []
        ];

        $this->sharedInstances[$abstract] = $instance ?? $this->make($abstract);
    }

    public function make(string $abstract, array $args = []) : mixed
    {
        if(!$this->isBound($abstract))
            return null;

        $binding = $this->bindings[$abstract];

        if($binding['shared'] and $this->sharedInstanceExists($abstract))
            return $this->sharedInstances[$abstract];

        $fnArgs = [];
        foreach($binding['parameters'] as $name => $opt) {
            if(isset($args[$name])) {
                $fnArgs[] = $args[$name];
            } elseif ($this->isBound($opt['class'])) {
                $fnArgs[] = $this->make($opt['class']);
            } elseif ($opt['optional']) {
                break;
            } else {
                $fnArgs[] = null;
            }
        }

        $res = call_user_func_array($binding['builder'], $fnArgs);
        if($binding['shared'])
            $this->sharedInstances[$abstract] = $res;

        return $res;
    }

    /**
     * @throws ReflectionException
     */
    private function setupFirstBindings() {
        static::setInstance($this);
        $this->instance('app', $this);
    }


}