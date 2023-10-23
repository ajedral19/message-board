<?php

class FriendsController
{
    /**
     * @return
     */
    public static function follow($view)
    {
        $params = Utils::extracParams($_SERVER['QUERY_STRING']);
        $user = apache_request_headers()['user_id'];

        // check if user is attempting to follow himself/herself
        if ($params[0]['id'] === $user)
            return Error('Cannot Follow yourself', 500);
            
        // follow other user
        $follow = Friends::follow($user, $params[0]['id']);
        return $view($follow);
    }

    /**
     * @return array list of followers
     */
    public static function followers($view)
    {
        if (!isset(apache_request_headers()['user_id']))
            return $view(Utils::sendErr("unknown key"));

        $user_id = apache_request_headers()['user_id'];


        $followers = Friends::followers($user_id);

        return $view($followers);
    }

    /**
     * @return array list of following
     */
    public static function following($view)
    {
        $user_id = apache_request_headers()['user_id'];
        $following = Friends::following($user_id);

        return $view($following);
    }
}
