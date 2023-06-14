<?php
class UserAuth
{
    private $connection;
    private $data;

    public function __construct($connection, $data)
    {
        $this->data = $data;
        $this->connection = $connection;
    }

    /**
     * @param object $cn database connection
     * @param object $data user login data
     * @return object
     * @author #
     */
    public static function login($cn, $data)
    {
        $query = "SELECT id, user_password as password FROM users WHERE user_name = :a";
        $stmt = $cn->prepare($query);
        $stmt->bindParam(':a', $data->username);

        Execute($cn, $stmt);

        $user = $stmt->fetch(PDO::FETCH_OBJ);

        if (!$user) return ["user" => 1];

        if (!password_verify($data->password, $user->password)) return ["password" => 1];

        $id = $user->id = Utils::shortenID($user->id);
        
        return ["id" => $id];
    }

    /**
     * @param string $password
     * @param string $repassword
     * @return object
     * @author #
     */
    public function register($password)
    {
        $query = "INSERT INTO users (first_name, last_name, user_name, user_email, user_password) VALUES (:a, :b, :c, :d, :e)";
        $stmt = $this->connection->prepare($query);

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt->bindParam(':a', $this->data->firstname);
        $stmt->bindParam(':b', $this->data->lastname);
        $stmt->bindParam(':c', $this->data->username);
        $stmt->bindParam(':d', $this->data->email);
        $stmt->bindParam(':e', $hashed_password);

        Execute($this->connection, $stmt);

        return !$stmt->fetch(PDO::FETCH_OBJ);
    }

    public function __destruct()
    {
        $this->connection = null;
        $this->data = null;
    }
}
