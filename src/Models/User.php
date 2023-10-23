<?php

class User extends UserSchema
{

    public static function profile($username)
    {
        $user = self::getUser($username);

        if (!$user)
            return Utils::sendErr("user not found");

        $user->image = Utils::get_image_uri($user->id);

        return Utils::send([$user]);
    }

    public static function update($data)
    {
        $update = self::updateUser($data);

        if ($update)
            return Utils::sendErr('Unable to do profile update');

        $responseData = [
            "firstname" => $data->firstname,
            "lastname" => $data->lastname
        ];

        return Utils::send($responseData);
    }

    // generic method
    public static function doExists($identifier, ?string $param = "username" | "email")
    {
        $col = null;

        if ($param === 'username')
            $col = "user_name";

        if ($param === 'email')
            $col = "user_email";

        // if (!$col)
        //     return false;

        $data =  self::userExists($identifier, $col);

        return $data['result'];
    }
}
