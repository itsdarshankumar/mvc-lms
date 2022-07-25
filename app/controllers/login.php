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



class Signup
{
    public function get()
    {
        echo \View\Loader::make()->render("templates/signup.twig");
    }
    public function post()
    {
        $bcrypt = new Bcrypt();
        $bcrypt_version = '2a';
        $username = $_POST["username"];
        $password = $_POST["password"];
        $password_repeat = $_POST["password_repeat"];
        $email = $_POST["email"];
        if ($password == $password_repeat) {
            $hash = $bcrypt->encrypt($password, $bcrypt_version);
            $rows = \Postlogin\Login::login($username);
            if ($rows) {
                echo "error in signup";
            } else {
                if (\Postlogin\Login::signupEntry($username, $email, $hash)) {
                    header("Location: /");
                } else {
                    echo "error in signup";
                }
            }
        } else {
            echo "error in signup";
        }
    }
}
class Logout
{
    public function get()
    {
        session_start();
        session_unset();
        session_destroy();
        header("Location: /");
        die();
    }
}
