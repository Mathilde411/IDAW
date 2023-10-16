<?php

namespace App\Database;

use App\Application;

class DatabaseManager
{
    protected ?DbConnection $connection = null;

    public function __construct(protected Application $app)
    {
        $type = config('database.type');
        if(isset($type)) {
            switch ($type) {
                case 'mysql':
                    $this->connection = new MySQLConnection();
            }
        }

        if(isset($this->connection))
            $this->connection->connect(config('database'));
    }

    public function connection() {
        return $this->connection;
    }
}