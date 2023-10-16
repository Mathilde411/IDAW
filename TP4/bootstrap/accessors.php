<?php

use App\Application;

function app(): ?Application
{
    return Application::getInstance();
}

function config(string $key, mixed $default = null) {
    $config = app()->make(\App\Config\Config::class);

    if(!isset($config))
        return $default;

    return $config->getConfig($key, $default);
}