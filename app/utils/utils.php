<?php

namespace Utils;

class Auth
{

    public static function userAuth()
    {
        session_start();
        if ($_SESSION["username"] && $_SESSION["role"] == 0) {
            return true;
        } else {
            header("Location: /");
            die();
        }
    }


    public static function adminAuth()
    {
        session_start();
        if ($_SESSION["username"] && $_SESSION["role"] == 1) {
            return true;
        } else {
            header("Location: /");
            die();
        }
    }


    public static function user()
    {
        session_start();
        if ($_SESSION["username"]) {
            return true;
        } else {
            header("Location: /");
            die();
        }
    }

}

