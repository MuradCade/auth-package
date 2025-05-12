<?php

namespace AuthPackage;

if (session_status() !== PHP_SESSION_ACTIVE) session_start();

class CSRFToken
{
    // Method to generate a new CSRF token
    public static function generateToken()
    {
        // Generate a random token
        $token = bin2hex(random_bytes(32));

        // Store token in session
        $_SESSION['csrf_token'] = $token;

        return $token;
    }

    // Method to validate the CSRF token
    public static function validateToken($token)
    {
        // Check if the token is set in the session and matches the provided token
        if (isset($_SESSION['csrf_token']) && $_SESSION['csrf_token'] === $token) {
            return true;
        }

        return false;
    }

    // Method to remove CSRF token after form submission
    public static function removeToken()
    {
        unset($_SESSION['csrf_token']);
    }
}
