<?php

function Execute($cn, $stmt, ?array $params = null)
{   
    try {
        $cn->beginTransaction();
        $stmt->execute($params ? $params : null);
        $cn->commit();
        $cn = null;
    } catch (PDOException $e) {
        $cn = null;
        $response = Utils::sendErr($e->getMessage());
        die($response);
    }
}
