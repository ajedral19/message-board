<?php
declare(strict_types = 1);

require __DIR__ . '/imports.php';

// default headers
header('Content-Type: application/json');

$router = new Router('connect');

// auth
$router->route('post', '/login', 'User', ['controller' => 'UsersAuthController', 'action' => 'loginUser']);
$router->route('post', '/register', 'User', ['controller' => 'UsersAuthController', 'action' => 'registerUser']);
$router->route('post', '/display-picture/upload', 'User', ['controller' => 'ImageController', 'action' => 'upload']);
// profile - working
$router->route('post', '/profile/update', 'User', ['controller' => 'UsersController', 'action' => 'updateProfile']);
$router->route('get', '/?user', 'User', ['controller' => 'UsersController', 'action' => 'getProfile']);
$router->route('get', '/?image', 'Image', ['controller' => 'ImageController', 'action' => 'getImage']);
// connections - ok
$router->route('get', '/connections/followers', 'User', ['controller' => 'FriendsController', 'action' => 'followers']);
$router->route('get', '/connections/following', 'User', ['controller' => 'FriendsController', 'action' => 'following']);
$router->route('post', '/follow/?id', 'User', ['controller' => 'FriendsController', 'action' => 'follow']);
// messages - todo
$router->route('post', '/message/?id', 'Image', ['controller' => 'ImageController', 'action' => 'get_image']);
$router->route('get', '/message/?id', 'Image', ['controller' => 'ImageController', 'action' => 'get_image']);

$router->serve();
