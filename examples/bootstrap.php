<?php

error_reporting(E_ALL);
chdir(__DIR__);

require_once '../vendor/autoload.php';
require_once 'model.php';

function dd($var)
{
    echo new Exception . "\n" . print_r($var, true) . "\n";
    exit;
}
