<?php
function Image($data)
{
    header("Content-type: " . $data['type']);
    header("Content-Disposition: inline; filename=\"" . $data['name'] . "\"");
    print base64_decode($data['base64']);
}
