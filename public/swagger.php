<?php
require(__DIR__ . "/../vendor/autoload.php");

$swagger = \Swagger\scan(__DIR__ . '/../src');
header('Content-Type: application/json');
echo $swagger;