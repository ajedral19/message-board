<?php

class FriendsController{

    public static function follow($view, $connection){
        $params = Utils::extracParams($_SERVER['QUERY_STRING']);
        return $view(Friends::follow($connection(), "", ""));
    }
}