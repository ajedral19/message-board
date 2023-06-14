<?php

class UsersController
{
    public static function getProfile($method, $view, $connection)
    {
        $params = Utils::extracParams($_SERVER['QUERY_STRING']);
        $user = User::profile($connection(), $params[0]['user']);

        $url = Utils::get_image_uri($user[0]->id);
        $user[0]->image = $url;
        return $view($user);
    }

    public static function updateProfile($method, $view, $connection)
    {
        $id = apache_request_headers()['user_id'];
        $data = json_decode(file_get_contents("php://input"));
        $params = ["firstname", "lastname"];
        $empty_fields = Utils::validateField($params, $data);

        if (count($empty_fields)) {
            return Error('Fields cannot be empty', 403);
        }

        $updated = User::save_update($connection(), $id, $data);

        if (!$updated)
            return Error('Unable to update', 500);

        $response = [
            "updated" => true
        ];

        return $view($response);
    }

    public static function changePassword()
    {
    }
}
