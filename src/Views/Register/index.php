<?php

function Register($payload)
{
    echo json_encode($payload);
    return;
    // $response = [];
    // $data = json_decode(file_get_contents('php://input'));

    // if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($data))
    //     $response = Utils::sendErr('Invalid request');

    // if (UsersAuthController::register(connect(), $data))
    //     $response = Utils::sendMsg("New user has been registered");

    // if ($response)
    //     print($response);
}