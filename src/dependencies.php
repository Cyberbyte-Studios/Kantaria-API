<?php
// DIC configuration

use Kantaria\Controllers\UserController;
use Kantaria\Controllers\HeroController;

$container = $app->getContainer();

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], Monolog\Logger::DEBUG));
    return $logger;
};

$container['UserController'] = function($container) {
    return new UserController($container);
};

$container['HeroController'] = function($container) {
    return new HeroController($container);
};