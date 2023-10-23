<?php
class UserSchema
{
    protected static function getUser($username)
    {
        $connection = Connect();
        $query = "SELECT LEFT(id, 8) as id, first_name as firstname, last_name as lastname, user_name as username, user_email as email, create_at as created_at FROM users where user_name like CONCAT(:a, '%')";
        $stmt = $connection->prepare($query);

        $stmt->bindParam(':a', $username);

        Execute($connection, $stmt);

        return;
    }

    protected static function updateUser($data)
    {
        $connection = Connect();
        $query = "UPDATE users SET first_name = :a, last_name = :b WHERE id LIKE CONCAT(:c, '%')";
        $stmt = $connection->prepare($query);

        $stmt->bindParam(':a', $data->firstname);
        $stmt->bindParam(':b', $data->lastname);
        $stmt->bindParam(':c', $data->id);

        Execute($connection, $stmt);

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    protected static function userExists($user, $column = null)
    {
        $connection = Connect();
        $query = "SELECT CASE WHEN EXISTS(SELECT 1 FROM users WHERE $column = :a ) THEN 1 ELSE 0 END AS result";
        if (!$column)
            $query = "SELECT CASE WHEN EXISTS(SELECT 1 FROM users WHERE id LIKE CONCAT(:a, '%') ) THEN 1 ELSE 0 END AS result";

        $stmt = $connection->prepare($query);

        $stmt->bindParam(':a', $user);

        Execute($connection, $stmt);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
