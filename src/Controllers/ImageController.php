<?php
class ImageController
{
    public static function image()
    {
    }

    public static function upload($method, $view, $connection)
    {
        $user = apache_request_headers()['user_id'];
        $image = $_FILES['image'];
        $imageBLob = Utils::encode_image($image['tmp_name'], $image['name'], $image['type']);

        return $view(Image::upload($connection(), $user, $imageBLob));
    }

    public static function get_image($method, $view, $connection)
    {
        $params = Utils::extracParams($_SERVER['QUERY_STRING']);
        $str = $params[0]['image'];
        $decoded_str = Utils::decode_id($str);

        $image_data = Image::get_image($connection(), $decoded_str);
        $data =Utils::decode_image($image_data->photo);

        return $view($data);
    }
}
