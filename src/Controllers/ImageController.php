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

        if (!$image['size'])
            return Error("No image to upload", 403);

        $imageBLob = Utils::encode_image($image['tmp_name'], $image['name'], $image['type']);
        $result = Image::upload($connection(), $user, $imageBLob);

        if (!$result)
            return Error('Unable to upload image', 403);

        return $view(['image' => Utils::get_image_uri($user)]);
    }

    public static function getImage($method, $view, $connection)
    {
        $params = Utils::extracParams($_SERVER['QUERY_STRING']);
        $str = $params[0]['image'];
        $decoded_str = Utils::decode_id($str);

        $image_data = Image::get_image($connection(), $decoded_str);
        $photo = $image_data->photo;

        if (!$photo)
            return Error('No photo', 401);

        $data = Utils::decode_image($image_data->photo);
        return $view($data);
    }
}
