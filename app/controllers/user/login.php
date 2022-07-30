<?php

namespace Controller;

use Bcrypt\Bcrypt;

class Login
{


    public function get()
    {
        session_start();
        if ($_SESSION["username"]) {
            header("Location: /book");
            die();
        } else {
            echo \View\Loader::make()->render("templates/login.twig");
        }
    }

    
    public function post()
    {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $bcrypt = new Bcrypt();
        $rows = \Postlogin\Login::login($username);
        if ($rows) {
            if ($bcrypt->verify($password, $rows[0]["pass"])) {
                session_start();
                $_SESSION["username"] = $username;
                $_SESSION["role"] = $rows[0]["role"];
                header("Location: /book");
                die();
            } else {
                echo "wrong credentials";
            }
        } else {
            echo "wrong credentials";
        }
    }
}





