<?php
class SecretKeyManager
{
    public static function getSecretKey()
    {
        $sessionKey = 'secretKeySession'; // Thay thế bằng một key duy nhất

        if (!isset($_SESSION[$sessionKey])) {
            $_SESSION[$sessionKey] = self::generateRandomString();
        }

        return $_SESSION[$sessionKey];
    }

    private static function generateRandomString($length = 32)
    {
        return bin2hex(random_bytes($length));
    }
}
