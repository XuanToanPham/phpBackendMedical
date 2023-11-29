<?php

$globalSecretKey = null;

function generateRandomString($length = 32)
{
    return bin2hex(random_bytes($length));
}

function getSecretKey()
{
    global $globalSecretKey;

    if ($globalSecretKey !== null) {
        return $globalSecretKey;
    }

    $globalSecretKey = generateRandomString();

    return $globalSecretKey;
}
