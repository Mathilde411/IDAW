<?php

namespace App\Model;

use App\Model\Model;

class User extends Model
{
    protected static string $table = "users";

    protected static array $attributes = [
        'id',
        'name',
        'email',
        'password'
    ];
}