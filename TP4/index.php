<?php
require __DIR__.'/vendor/autoload.php';

$mysqlConfig = require("config/database.php");

$app = new App\App();

$app->bind(\App\Database\DbConnection::class, \App\Database\MySQLConnection::class, true);
$test = $app->make(\App\Database\DbConnection::class, ['config' => $mysqlConfig]);
echo "Test";
