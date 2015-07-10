<?php 

use Symfony\Component\HttpFoundation\Request;

$app->get('/hello', "app.controller:home")->bind('home');
$app->post('/hello', "app.controller:post")->bind('post');

$app->get('/login', "app.controller:login")->bind('login');
$app->post('/login', "app.controller:authenticate")->bind('authenticate');
$app->get('/logout', "app.controller:logout")->bind('logout');

$app->get('/create', "app.controller:createUserForm")->bind('user.create');
$app->post('/create', "app.controller:createUser");