<?php

namespace Controller;

class Login
{
    public function get()
    {
        echo \View\Loader::make()->render("templates/login.twig");
    }

    public function post()
    {
        $username = $_POST["username"];
        $pass = $_POST["pass"];
        if (\Postlogin\Login::login($username, $pass)) {
            $role = $_SESSION["role"];
            echo \View\Loader::make()->render("templates/home.twig", array(
                "books" => \Postlogin\Login::get_all($role),
                "role"  => $_SESSION["role"]
            ));
        } else {
            echo "wrong credentials";
        }
    }
}
class Book
{
    public function get()
    {
        $search = $_GET['search'];
        $role = $_SESSION["role"];
        echo \View\Loader::make()->render("templates/home.twig", array(
            "books" => \Postlogin\Login::get_all($role, $search),
            "role"  => $_SESSION["role"]
        ));
    }
    public function post()
    {
        $bookid = $_POST["bookid"];
        $username = $_SESSION["username"];
        if (\Postlogin\Login::checkout($username, $bookid)) {
            echo "Checkout successfull";
        } else {
            echo "error";
        }
    }
}
