<?php

use App\Application;

$app = new Application(
    dirname(__DIR__)
);

$app->singleton(
    App\Http\Kernel::class
);

$app->singleton(
    App\Config\Config::class
);

$app->singleton(
    App\Database\DatabaseManager::class
);

require "accessors.php";

return $app;