<?php

namespace AuthPackage;

class Validator
{
    // Validate email format
    public static function validateEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    // Validate password strength (at least 8 characters, including one uppercase letter, one lowercase letter, one number, and one special character)
    public static function validatePassword($password)
    {
        return preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password);
    }

    // Validate if a field is not empty
    public static function validateRequired($field)
    {
        return !empty(trim($field));
    }

    // Validate if a field matches a regular expression (e.g., for username)
    public static function validateRegex($field, $pattern)
    {
        return preg_match($pattern, $field);
    }
}
