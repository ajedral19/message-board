<?php

class FriendsController{

    public static function follow($view, $connection){
        $params = Utils::extracParams($_SERVER['QUERY_STRING']);
        $user = apache_request_headers()['user_id'];
        // return;
        return $view(Friends::follow($connection(), $params[0]['id'], $user));
    }
}