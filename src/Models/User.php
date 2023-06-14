<?php

class User
{

    protected ?object $connection;
    protected $id = "";
    private $firstname = "";
    private $lastname = "";
    private $username = "";
    private $email = "";
    private $photo = "";
    private $created_at = "";

    public function __construct($connection, $data)
    {
        $this->connection = $connection;
        $this->id         = $data->id;
        $this->firstname  = $data->firstname;
        $this->lastname   = $data->lastname;
        $this->username   = $data->username;
        $this->email      = $data->email;
        $this->photo      = $data->photo;
        $this->created_at = $data->created_at;
    }

    /**
     * @param object $connection database connection
     * @param string $id
     * @return object
     * @author #
     */
    public static function profile($connection, $username)
    {
        $query = "SELECT LEFT(id, 8) as id, first_name as firstname, last_name as lastname, user_name as username, user_email as email, create_at as created_at FROM users where user_name like ?";

        $stmt = $connection->prepare($query);
        $params = ["$username%"];

        Execute($connection, $stmt, $params);

        $user = $stmt->fetch(PDO::FETCH_OBJ);

        if (!$user) return;

        return [$user];
    }

    public static function save_update($connection, $id, $data)
    {
        $query = "UPDATE users SET first_name = ?, last_name = ? WHERE id LIKE ?";
        $stmt = $connection->prepare($query);
        $params = [$data->firstname, $data->lastname, "$id%"];

        Execute($connection, $stmt, $params);

        return !$stmt->fetch(PDO::FETCH_OBJ);
    }

    // generic method
    public static function doExists($connection, $identifier, string $param = "username" | "email")
    {
        $col = "";

        if ($param === 'username')
            $col = "user_name";

        if ($param === 'email')
            $col = "user_email";

        $query = "SELECT CASE WHEN EXISTS(SELECT 1 FROM users WHERE $col = :a ) THEN 1 ELSE 0 END AS result";

        $stmt = $connection->prepare($query);
        $stmt->bindParam(':a', $identifier);

        Execute($connection, $stmt);

        $result =  $stmt->fetch(PDO::FETCH_ASSOC)['result'];

        return $result;
    }
}
