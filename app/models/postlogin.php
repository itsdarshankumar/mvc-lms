<?php

namespace Postlogin;

use Bcrypt\Bcrypt;

class Login
{


    public static function login($username)
    {
        $db = \DB::get_instance();
        $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $rows = $stmt->fetchAll();
        if ($rows) {

            return $rows;
        }

        return false;
    }



    public static function signupEntry($username, $email, $hash)
    {


        $db = \DB::get_instance();

        $stmt = $db->prepare("INSERT INTO users (username,email,pass,role) VALUES (?,?,?,0)");
        $stmt->execute([$username, $email, $hash]);
        return true;
    }

    
}
