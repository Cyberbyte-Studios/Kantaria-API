<?php
// Routes

$app->get('/user/{id}', 'UserController:viewAction');
$app->post('/user/create', 'UserController:createAction');

$app->get('/character/{id}', 'HeroController:viewAction');
$app->post('/character/create', 'HeroController:createAction');