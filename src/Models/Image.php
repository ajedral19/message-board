<?php
class Image extends ImageSchema
{
    public static function uplaod($id, $data)
    {
        $upload = self::uploadImage($id, $data);

        if ($upload)
            return Utils::sendErr('Unable to upload image');

        return Utils::send([Utils::get_image_uri($id)]);
    }

    public static function get_image($id)
    {
        $image = self::getImage($id);
        return Utils::decode_image($image->photo);
    }
}
