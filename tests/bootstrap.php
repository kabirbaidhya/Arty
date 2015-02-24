<?php

error_reporting(E_ALL);

$loader = require __DIR__.'/../vendor/autoload.php';
$loader->addPsr4('Gckabir\\MyPackage\\', __DIR__.'/MyPackage');
