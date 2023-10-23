<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
class UserAuth extends UserAuthSchema
{

    public static function register($data)
    {
        $registered = self::addUser($data);

        if ($registered)
            return Utils::sendErr('Unable to register new user');

        return Utils::sendMsg('New user have been registered');
    }

    public static function login($data)
    {
        $user = self::getUser($data->username);

        if (!$user)
            return Utils::sendErr("user $data->username does not exists", 400);

        if (!password_verify($data->password, $user->password))
            return Utils::sendErr("Your passsord is incorrect", 400);

        // get user info and assign it to token
        $key = "sample key";
        $payload = [
            'iss' => 'http://example.org',
            'aud' => 'http://example.com',
            'iat' => 1356999524,
            'nbf' => 1357000000
        ];

        $jwt = JWT::encode($payload, $key, 'HS256');
        $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
        print($decoded);

        $user->id = Utils::shortenID($user->id);
        unset($user->password);

        // set token to header
        header("Authentication: Bearer SomeToken");
        return Utils::send([($user)]);
    }
}
