<?php

declare(strict_types=1);

include_once __DIR__.'/../vendor/autoload.php';

$dotenv = new Symfony\Component\Dotenv\Dotenv();
$dotenv->loadEnv(__DIR__.'/../.env');
