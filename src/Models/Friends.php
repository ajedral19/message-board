<?php

class Friends
{
    public static function follow($connection, $id, $id_2)
    {
        $query = "INSERT INTO friends(user_id, user_friend_id) SELECT u1.id, u2.id FROM users u1 JOIN users u2 ON u1.id LIKE CONCAT(:a, '%') WHERE u2.id LIKE CONCAT(:b, '%');";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':a', $id);
        $stmt->bindParam(':b', $id_2);

        Execute($connection, $stmt);

        return;
    }

    public static function followers($connection, $id)
    {
        $query = "SELECT LEFT(users.id, 8) as id, users.first_name, users.last_Name FROM users LEFT JOIN friends ON users.id = friends.user_id WHERE friends.user_friend_id LIKE CONCAT(:a, '%');";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':a', $id);

        Execute($connection, $stmt);

        $followers = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $followers;
    }

    public static function following($connection, $id)
    {
        $query = "SELECT LEFT(users.id, 8) as id, users.first_name, users.last_Name FROM users LEFT JOIN friends ON users.id = friends.user_friend_id WHERE friends.user_id LIKE CONCAT(:a, '%');";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':a', $id);

        Execute($connection, $stmt);

        $following = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $following;
    }
}
