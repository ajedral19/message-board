<?php 

function Error($msg, $status_code){

    http_response_code($status_code);
    print Utils::sendErr($msg);
}