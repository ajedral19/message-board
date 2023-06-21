<?php
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
            return Utils::sendErr("user $data->username does not exists");

        if (!password_verify($data->password, $user->password))
            return Utils::sendErr("Your passsord is incorrect");

        $user->id = Utils::shortenID($user->id);
        unset($user->password);

        return Utils::send([($user)]);
    }
}
