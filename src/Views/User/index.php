<?php

function User($payload)
{
    $response = Utils::send($payload);
    print($response);

}

/**
 * @return void
 * @author #
 */
function GetUser()
{
    $response = null;
    $user_id = getallheaders()['user_id'];

    if ($_SERVER['REQUEST_METHOD'] !== 'GET')
        $response = Utils::sendErr('Invalid request');

    if (isset($user_id) && !empty($user_id)) {
        if ($user = UsersController::getUser(connect(), $user_id))
            $response = Utils::send($user);
    } else {
        $response = Utils::sendErr('Invalid request');
    }

    if ($response)
        print($response);
}

/**
 * @return void
 * @author #
 */
function GetUsers()
{
    $response = null;

    if ($_SERVER['REQUEST_METHOD'] !== 'GET')
        $response = Utils::sendErr('Invalid request');

    if ($users = UsersController::getUsers('connect'))
        $response = Utils::send($users);

    if ($response)
        print($response);
}

/**
 * @return void
 * @author #
 */
function UpdateUserInfo()
{
}

/**
 * @return void
 * @author #
 */
function DeactivateUser()
{
}

/**
 * @return void
 * @author #
 */
function DeleteUser()
{
}

/**
 * @return void
 * @author #
 */
function Follow()
{
    $response = null;
    $paras  = [];


    foreach ($_SERVER['QUERY_STRING'] as $key => $value) {
        # code...
        echo $key;
    }

    print($response);
}

/**
 * @return void
 * @author #
 */
function Unfollow()
{
}
