<?php

namespace App\Model;

class User extends Model
{
    protected static string $table = "users";

    protected static array $publicAttributes = [
        "id",
        "name",
        "email"
    ];
}