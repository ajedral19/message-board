<?php 

function Error($payload){

    http_response_code(404);
    echo $payload;
}