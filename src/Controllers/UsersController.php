<?php

class UsersController
{
    public static function getUser($method, $view, $connection)
    {
        $params = Utils::extracParams($_SERVER['QUERY_STRING']);

        return $view(User::getUser($connection(), $params[0]['user']));

    }

    public static function getUsers($view, $connection)
    {
        return $view(User::getUsers($connection()));
    }

    public static function follow($view)
    {
        return $view(Utils::sendMsg('you are now a follower'));
    }
}
