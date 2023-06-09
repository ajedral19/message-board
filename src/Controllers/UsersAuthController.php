<?php

use function PHPSTORM_META\type;

class UsersAuthController
{

    /**
     * 
     */
    public static function login($method, $view, $connection = null)
    {
        $data = json_decode(file_get_contents("php://input"));
        $params = ['username', 'password'];
        $empty_fields = Utils::validateField($params, $data);

        if (count($empty_fields)) {
            $response = Utils::sendErr('Fields cannot be empty');
            print($response);
            return;
        }

        if (!$user = UserAuth::login($connection(), $data)) {
            $response = Utils::sendErr('Incorrect username or password');
            print($response);
            return;
        }

        // send response to cookie/session/cache/header
        // header('location: http://localhost/message_board_new/user');
        return $view($user);

        // return $user;
    }

    /**
     * 
     */
    public static function register($method, $view, $connection)
    {

        $data = json_decode(file_get_contents("php://input"));
        // echo json_encode($data);
        // return;
        // $data =  explode(",", $_REQUEST['data']);
        // $data =  json_decode($_REQUEST['data']);

        $params = ['firstname', 'lastname', 'username', 'email', 'password', 'confirm_password'];
        $empty_fields = Utils::validateField($params, $data);

        if (count($empty_fields)) {
            $response = Utils::sendErr('Fields cannot be empty');
            print($response);
            return;
        }

        if (User::doExists($connection(), $data->email, 'email')) {
            $response = Utils::sendErr("$data->email already exist.");
            print($response);
            return;
        }

        if (User::doExists($connection(), $data->username, 'username')) {
            $response = Utils::sendErr("$data->username already exist.");
            print($response);
            return;
        }

        if ($data->password !== $data->confirm_password) {
            $response = Utils::sendErr("Paasword doesn't match");
            print($response);
            return;
        }

        $user = new UserAuth($connection(), $data);

        $user->register($data->password);

        $view($user);

        return true;
    }

    private static function blobImage()
    {

        $tmp_name = $_FILES['image']['tmp_name'];
        $file = $_FILES['image']['name'];
        $type = $_FILES['image']['type'];
        $format = pathinfo($file, PATHINFO_EXTENSION);
        $size = $_FILES['image']['size'];

        $fp = fopen($tmp_name, 'r');
        $file_content = fread($fp, $size);
        fclose($fp);
        $base64 = 'data/image/' . $format . ';base64' . base64_encode($file_content);

        return $base64;

        $path = "c:/xampp/htdocs/message_board_new/src/assets/images/inqn5n0m6bufa_230.jpg";
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64' . base64_encode($data);

        // decode
        $data = $base64;
        list($type, $data) = explode(';', $data);
        // list($data) = explode(',', $data);
        $data = base64_decode($data);

        // echo $base64;
        file_put_contents('image.jpg', $data);
    }

    private static function unblobImage($base64)
    {
        list($info, $blob) = explode(';', $base64);
        list(, $data) = explode('base64/', $blob);
        list(, $type, $format) = explode('/', $info);

        $imgData = base64_decode($data);
        file_put_contents(uniqid() . $format, $imgData);

        // $imageData = base64_decode($imageData);
        // file_put_contents($filename, $imageData);
    }
}
