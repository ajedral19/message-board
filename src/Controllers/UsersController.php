<?php

class UsersController
{
    public static function getUser($method, $view, $connection)
    {
        $params = Utils::extracParams($_SERVER['QUERY_STRING']);
        $user = User::getUser($connection(), $params[0]['user']);
        
        $url = Utils::get_image_uri($user[0]->id);
        $user[0]->image = $url;
        return $view($user);
    }
}
