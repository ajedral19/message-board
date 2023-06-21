<?php
class ImageController
{
    public static function image()
    {
    }

    public static function upload($view)
    {
        $user = apache_request_headers()['user_id'];
        $image = $_FILES['image'];

        if (!$image['size'])
            return Error("No image to upload", 403);

        $enconded_image = Utils::encode_image($image);
        $response = Image::uplaod($user, $enconded_image);

        return $view($response);
    }

    public static function getImage($view)
    {
        $params = Utils::extracParams($_SERVER['QUERY_STRING']);
        $str = $params[0]['image'];
        $decoded_str = Utils::decode_id($str);

        $response = Image::get_image($decoded_str);

        return $view($response);
    }
}
