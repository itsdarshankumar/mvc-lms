<?php

namespace Controller;

use Bcrypt\Bcrypt;



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