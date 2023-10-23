<?php
class FriendsSchema
{
    protected static function addConnection(string $follower_id, string $following_id)
    {
        $connection = Connect();
        $query = "INSERT INTO friends(user_id, user_friend_id) SELECT u1.id, u2.id FROM users u1 JOIN users u2 ON u1.id LIKE CONCAT(:a, '%') WHERE u2.id LIKE CONCAT(:b, '%');";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':a', $follower_id);
        $stmt->bindParam(':b', $following_id);

        Execute($connection, $stmt);

        return !$stmt->fetch(PDO::FETCH_COLUMN);
    }

    protected static function isFollowing(string $follower_id, string $following_id): bool{
        
        $connection = Connect();
        $query = "SELECT 1 FROM friends WHERE user_id LIKE CONCAT(:a, '%') AND user_friend_id LIKE CONCAT(:b, '%')";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':a', $follower_id);
        $stmt->bindParam(':b', $following_id);

        Execute($connection, $stmt);

        return $stmt->fetch(PDO::FETCH_COLUMN);
    }

    protected static function getConnections(string $user_id, string $type)
    {
        $type_value = strtolower($type);

        if (!in_array($type, ['followers', 'following']))
            return; // create error

        $connection = Connect();
        $query = "";

        if ($type_value === 'followers')
            $query = "SELECT LEFT(users.id, 8) as id, users.first_name, users.last_Name FROM users LEFT JOIN friends ON users.id = friends.user_id WHERE friends.user_friend_id LIKE CONCAT(:a, '%');";
        if ($type_value === 'following')
            $query = "SELECT LEFT(users.id, 8) as id, users.first_name, users.last_Name FROM users LEFT JOIN friends ON users.id = friends.user_friend_id WHERE friends.user_id LIKE CONCAT(:a, '%');";

        $stmt = $connection->prepare($query);
        $stmt->bindParam(':a', $user_id);

        Execute($connection, $stmt);

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
