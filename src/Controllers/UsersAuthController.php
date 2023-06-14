<?php

use function PHPSTORM_META\type;

class UsersAuthController
{

    /**
     * 
     */
    public static function login($method, $view, $connection = null)
    {
        $data = json_decode(file_get_contents("php://input"));
        $params = ['username', 'password'];
        $empty_fields = Utils::validateField($params, $data);

        if (count($empty_fields)) {
            $response = Utils::sendErr('Fields cannot be empty');
            print($response);
            return;
        }

        $user = UserAuth::login($connection(), $data);

        if (isset($user['user']) && $user['user']) {
            $response = Utils::sendErr('user does not exist');
            print($response);
            return;
        }

        if (isset($user['password']) && $user['password']) {
            $response = Utils::sendErr('password is incorrect');
            print($response);
            return;
        }

        // send response to cookie/session/cache/header
        // header('location: http://localhost/message_board_new/user');
        return $view($user);

        // return $user;
    }

    /**
     * 
     */
    public static function register($method, $view, $connection)
    {
        $data = json_decode(file_get_contents("php://input"));

        $params = ['firstname', 'lastname', 'username', 'email', 'password', 'confirm_password'];
        $empty_fields = Utils::validateField($params, $data);

        if (count($empty_fields)) {
            $response = Utils::sendErr('Fields cannot be empty');
            print($response);
            return;
        }

        if (User::doExists($connection(), $data->email, 'email')) {
            $response = Utils::sendErr("$data->email already exist.");
            print($response);
            return;
        }

        if (User::doExists($connection(), $data->username, 'username')) {
            $response = Utils::sendErr("$data->username already exist.");
            print($response);
            return;
        }

        if ($data->password !== $data->confirm_password) {
            $response = Utils::sendErr("Paasword doesn't match");
            print($response);
            return;
        }

        $user = new UserAuth($connection(), $data);
        $register = $user->register($data->password);

        if (!$register)
            return Error('Unable to register', 403);

        $response = [
            "registered" => true
        ];

        return $view($response);
    }

    public static function authorizeUser()
    {
    }
}
