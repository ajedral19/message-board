<?php
// imports
require __DIR__ . '/src/utils/utils.php';
require __DIR__ . '/src/Config/Database.php';
require __DIR__ . '/src/Router.php';
// models
require __DIR__ . '/src/Models/User.php';
require __DIR__ . '/src/Models/Friends.php';
require __DIR__ . '/src/Models/UserAuth.php';
require __DIR__ . '/src/Models/Execute.php';
// controllers
require __DIR__ . '/src/Controllers/UsersAuthController.php';
require __DIR__ . '/src/Controllers/UsersController.php';
require __DIR__ . '/src/Controllers/FriendsController.php';
// views
include __DIR__ . '/src/Views/Login/index.php';
include __DIR__ . '/src/Views/Register/index.php';
include __DIR__ . '/src/Views/User/index.php';
include __DIR__ . '/src/Views/Error.php';

// default headers
header('Content-Type: application/json');
// set headers here

//  auth check here

// routes
$router = new Router('connect');
// auth
$router->route('post', '/login', 'Login', ['controller' => 'UsersAuthController', 'action' => 'login']);
$router->route('post', '/register', 'Register', ['controller' => 'UsersAuthController', 'action' => 'register']);

// account - ok but change view
$router->route('post', '/update', 'Login', ['controller' => 'UsersAuthController', 'action' => 'register']);
$router->route('post', '/deactivate', 'Login', ['controller' => 'UsersAuthController', 'action' => 'register']);
// todo
$router->route('post', '/activate', 'Login', ['controller' => 'UsersAuthController', 'action' => 'register']);
$router->route('post', '/delete', 'Login', ['controller' => 'UsersAuthController', 'action' => 'register']);

// profile - ok
$router->route('get', '/?user', 'User', ['controller' => 'UsersController', 'action' => 'getUser']);

// connections - ok
$router->route('get', '/connections/followers', 'User', ['controller' => 'FriendsController', 'action' => 'followers']);
$router->route('get', '/connections/following', 'User', ['controller' => 'FriendsController', 'action' => 'following']);
// still need conditions
$router->route('post', '/follow/?id', 'User', ['controller' => 'FriendsController', 'action' => 'follow']);

$router->serve();