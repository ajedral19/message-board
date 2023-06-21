<?php
class UserAuthSchema
{
    protected static function addUser($data)
    {
        $connection = Connect();
        $query = "INSERT INTO users (first_name, last_name, user_name, user_email, user_password) VALUES (:a, :b, :c, :d, :e)";
        $stmt = $connection->prepare($query);

        $stmt->bindParam(":a", $data->firstname);
        $stmt->bindParam(":b", $data->lastname);
        $stmt->bindParam(":c", $data->username);
        $stmt->bindParam(":d", $data->email);
        $stmt->bindParam(":e", $data->password);

        Execute($connection, $stmt);

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    protected static function getUser($user)
    {
        $connection = Connect();
        $query = "SELECT id, user_password AS password FROM users WHERE user_name = :a";
        $stmt = $connection->prepare($query);

        $stmt->bindParam(':a', $user);

        Execute($connection, $stmt);

        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}
