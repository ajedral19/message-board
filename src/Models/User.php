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
     * @param object $cn database connection
     * @param string $id
     * @return object
     * @author #
     */
    public static function getUser($cn, $username)
    {
        $query = "SELECT LEFT(id, 8) as id, first_name as firstname, last_name as lastname, user_name as username, user_email as email, create_at as created_at FROM users where user_name like ?";
        $stmt = $cn->prepare($query);

        $params = ["$username%"];

        Execute($cn, $stmt, $params);

        $user = $stmt->fetch(PDO::FETCH_OBJ);

        if (!$user) return;

        return [$user];
    }

    /**
     * @param object $cn database connection
     * @return object
     * @author #
     */
    public static function getUsers($cn)
    {
        // $query = "SELECT LEFT(id, 8) as id, first_name AS firstname, last_name AS lastname, user_name AS username, user_email AS email, user_photo as photo, create_at as created_at FROM users";
        $query = "SELECT users.user_name FROM users INNER JOIN friends ON users.id=friends.user_friend_id WHERE friends.user_id LIKE ?";
        $stmt = $cn->prepare($query);

        Execute($cn, $stmt);

        $users = $stmt->fetchall(PDO::FETCH_OBJ);

        if (!$users) return;

        return $users;
    }

    /**
     * @param
     * @return
     * @author #
     */
    public function updateUser($data)
    {
        // validate empty properties
        $this->firstname = $data->firstname;
        $this->lastname = $data->lastname;
        $this->username = $data->username;
        $this->email = $data->email;
        $this->photo = $data->photo;
    }

    /**
     * @param
     * @return
     * @author #
     */
    public function saveUpdateUser($data)
    {
        $query = "UPDATE users SET first_name = :a, last_name = :b, user_name = :c, user_email = :d, user_photo = :e WHERE id like ?";
        $stmt = $this->connection->prepare($query);

        $id = $this->id;
        $params = ["$id%"];

        $stmt->bindParam(':a', $this->firstname);
        $stmt->bindParam(':a', $this->lastname);
        $stmt->bindParam(':a', $this->username);
        $stmt->bindParam(':a', $this->email);
        $stmt->bindParam(':a', $this->photo);

        Execute($this->connection, $stmt, $params);

        $user = $stmt->fetch(PDO::FETCH_OBJ);

        if ($user) return;

        return $user;
    }

    /**
     * @param
     * @return
     * @author #
     */
    public function deactivateUser($id)
    {
    }

    /**
     * @param
     * @return
     * @author #
     */
    public function reactivateUser($id)
    {
    }

    /**
     * @param
     * @return
     * @author #
     */
    public function removeUser($id)
    {
        return [];
    }

    public static function doExists($cn, $identifier, string $param = "username" | "email")
    {
        $col = "";

        if ($param === 'username')
            $col = "user_name";

        if ($param === 'email')
            $col = "user_email";

        $query = "SELECT CASE WHEN EXISTS(SELECT 1 FROM users WHERE $col = :a ) THEN 1 ELSE 0 END AS result";

        $stmt = $cn->prepare($query);

        $stmt->bindParam(':a', $identifier);

        Execute($cn, $stmt);

        $result =  $stmt->fetch(PDO::FETCH_ASSOC)['result'];

        return $result;
    }
}
