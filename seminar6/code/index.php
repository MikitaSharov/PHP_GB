<?php
//ini_set('session.save_handler', 'memcached');
//ini_set('session.save_path', 'memcache:11211');
session_start();

require_once(__DIR__ . '/vendor/autoload.php');

use Geekbrains\Application1\Application\Application;
use Geekbrains\Application1\Application\Render;

$app = new Application();
echo $app->run();
