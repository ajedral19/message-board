<?php

class Friends
{
    public static function follow($connection, $id, $id_2)
    {
        $query = "INSERT INTO friends (user_id, user_friend_id) VALUES (SELECT id FROM users WHERE id like :a, SELECT id FROM users WHERE id like :b)";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':a', $id);
        $stmt->bindParam(':b', $id_2);

        Execute($connection, $stmt);

        return;
    }
}
