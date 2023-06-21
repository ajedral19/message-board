<?php

class ImageSchema
{
    protected static function uploadImage($id, $data)
    {
        $connection = Connect();
        $query = "UPDATE users SET user_photo = :a WHERE id LIKE CONCAT(:b, '%')";
        $stmt = $connection->prepare($query);

        $stmt->bindParam(':a', $data);
        $stmt->bindParam(':b', $id);

        Execute($connection, $stmt);

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    protected static function getImage($id)
    {
        $connection = Connect();
        $query = "SELECT user_photo as photo from users WHERE id LIKE CONCAT(:a, '%')";
        $stmt = $connection->prepare($query);

        $stmt->bindParam(':a', $id);

        Execute($connection, $stmt);

        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}
