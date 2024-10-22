<?php

require('./vendor/autoload.php');

use App\Oop\App;

$app = new App();
echo $app->run();