<?php
class UsersAuthController extends UserAuth
{

    public static function loginUser($view)
    {
        $data = json_decode(file_get_contents("php://input"));
        $params = ['username', 'password'];
        $empty_fields = Utils::validateField($params, $data);

        if (count($empty_fields))
            return $view(Utils::sendErr('Fields cannot be empty'));

        return $view(self::login($data));
    }

    public static function registerUser($view)
    {
        $data = json_decode(file_get_contents("php://input"));

        $params = ['firstname', 'lastname', 'username', 'email', 'password', 'confirm_password'];
        $empty_fields = Utils::validateField($params, $data);

        if (count($empty_fields))
            return $view(Utils::sendErr('Fields cannot be empty'));

        if (User::doExists($data->username, 'username'))
            return $view(Utils::sendErr("$data->username already exist."));

        if (User::doExists($data->email, 'email'))
            return $view(Utils::sendErr("$data->email already exist."));

        if ($data->password !== $data->confirm_password)
            return $view(Utils::sendErr("Paasword doesn't match"));

        $hashed = password_hash($data->password, PASSWORD_DEFAULT);
        $data->password = $hashed;

        return $view(self::register($data));
    }

    public static function authorizeUser()
    {
    }
}
