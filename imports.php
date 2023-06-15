<?php
// imports
require __DIR__ . '/src/utils/utils.php';
require __DIR__ . '/src/Config/Database.php';
require __DIR__ . '/src/Router.php';
// models
require __DIR__ . '/src/Models/User.php';
require __DIR__ . '/src/Models/Friends.php';
require __DIR__ . '/src/Models/UserAuth.php';
require __DIR__ . '/src/Models/Image.php';
require __DIR__ . '/src/Models/Execute.php';
// controllers
require __DIR__ . '/src/Controllers/UsersAuthController.php';
require __DIR__ . '/src/Controllers/UsersController.php';
require __DIR__ . '/src/Controllers/FriendsController.php';
require __DIR__ . '/src/Controllers/ImageController.php';
// views
include __DIR__ . '/src/Views/Login/index.php';
include __DIR__ . '/src/Views/Register/index.php';
include __DIR__ . '/src/Views/User.php';
include __DIR__ . '/src/Views/Error.php';
include __DIR__ . '/src/Views/Image.php';