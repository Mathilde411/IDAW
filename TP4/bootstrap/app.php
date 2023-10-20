<?php

use App\Application;

require __DIR__.'/../vendor/autoload.php';

$app = new Application(
    dirname(__DIR__)
);

return $app;