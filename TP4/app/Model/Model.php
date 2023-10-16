<?php

namespace App\Model;


use App\Facade\Database;

class Model
{
    protected static string $primaryKey = 'id';
    protected static string $table;
    protected static array $attributes;

    private array $data = [];
    private null|\App\Database\MySQLConnection|\App\Database\DbConnection $connection;

    public function __construct()
    {
        $this->connection = Database::connection();
    }
}