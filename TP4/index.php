<?php

use App\Facade\App;
use App\Model\User;

require __DIR__.'/vendor/autoload.php';

$app = require __DIR__.'/bootstrap/app.php';

$db = new User();

echo config("database.host", "nop");
