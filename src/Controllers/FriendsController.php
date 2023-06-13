<?php

class FriendsController
{
    /**
     * @return
     */
    public static function follow($method, $view, $connection)
    {
        $params = Utils::extracParams($_SERVER['QUERY_STRING']);
        $user = apache_request_headers()['user_id'];

        return $view(Friends::follow($connection(), $user, $params[0]['id']));
    }

    /**
     * @return array list of followers
     */
    public static function followers($method, $view, $connection)
    {
        $id = apache_request_headers()['user_id'];
        $followers = Friends::followers($connection(), $id);

        foreach ($followers as $key => $follower) {
            $follower->image = Utils::get_image_uri($follower->id);
        }

        return $view($followers);
    }

    /**
     * @return array list of following
     */
    public static function following($method, $view, $connection)
    {
        $id = apache_request_headers()['user_id'];
        $following = Friends::following($connection(), $id);

        foreach ($following as $key => $user) {
            $user->image = Utils::get_image_uri($user->id);
        }

        return $view($following);
    }
}
