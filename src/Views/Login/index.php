<?php


// function Login($method, $payload)
function Login($payload)
{
    // set headers
    header('user_id_test:' . $payload['id']);
    
    $data = Utils::send($payload);

    print $data;
    return;
}
