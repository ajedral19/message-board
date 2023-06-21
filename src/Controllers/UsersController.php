<?php
class UsersController
{
    public static function getProfile($view)
    {
        $params = Utils::extracParams($_SERVER['QUERY_STRING']);
        $user = User::profile($params[0]['user']);

        return $view($user);
    }

    public static function updateProfile($view)
    {
        $id = apache_request_headers()['user_id'];
        $data = json_decode(file_get_contents("php://input"));
        $params = ["firstname", "lastname"];
        $empty_fields = Utils::validateField($params, $data);

        if (count($empty_fields))
            return Error('Fields cannot be empty', 403);

        $data->id = $id;
        $user = User::update($data);

        return $view($user);
    }

    public static function changePassword()
    {
    }
}
