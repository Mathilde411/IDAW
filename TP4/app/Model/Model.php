<?php

namespace App\Model;

class Model
{
    protected static string $primaryKey = 'id';
    protected static string $table;
    protected static array $attributes;

    private array $data = [];
}