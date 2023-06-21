<?php

function Connect()
{
    $host = "127.0.0.1";
    $db = "message_board";
    $user = "root";
    $pword = "";
    $dsn = "mysql:host=" . $host . ";dbname=" . $db;

    try {
        return new PDO($dsn, $user, $pword);
    } catch (PDOException $e) {
        Utils::log($e->getMessage());
        $response = Utils::sendErr('Server Error');
        die($response);
    }
}
    // new PDO("mysql:host=hostname;dbname=database", username, password, options:optional);