<?php
class Image
{
    public static function upload($connection, $id, $data)
    {
        $query = "UPDATE users SET user_photo = :a WHERE id LIKE CONCAT(:b, '%')";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':a', $data);
        $stmt->bindParam(':b', $id);

        Execute($connection, $stmt);
        
        return !$stmt->fetch(PDO::FETCH_OBJ);
    }

    public static function get_image($connection, $id)
    {
        $query = "SELECT user_photo as photo from users WHERE id LIKE CONCAT(:a, '%')";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':a', $id);

        Execute($connection, $stmt);

        $image = $stmt->fetch(PDO::FETCH_OBJ);

        return $image;
    }
}
