<?php

namespace AuthPackage;

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

class Session
{

    public static function setsession($data = array())
    {
        $_SESSION['fullname'] = $data['fullname'];
        $_SESSION['userid'] = $data['userid'];
        $_SESSION['useremail'] = $data['useremail'];
        $_SESSION['user_role'] = $data['user_role'];
    }
}
