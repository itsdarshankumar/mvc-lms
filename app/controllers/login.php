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
        $rows = \Postlogin\Login::login($username,$pass);
        if ($rows) {
            session_start();
            $_SESSION["username"] = $username;
            $_SESSION["role"] = $rows[0]["role"];
            echo \View\Loader::make()->render("templates/home.twig", array(
                "books" => \Postlogin\Login::get_all($_SESSION["role"]),
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
    {   session_start();
        $_POST = json_decode(file_get_contents("php://input"), true);
        $bookid = $_POST["bookid"];
        $username = $_SESSION["username"];
        echo var_dump($_POST);
        echo var_dump($bookid);
        if (\Postlogin\Login::checkout($username, $bookid)) {
            echo "Checkout successfull";
        } else {
            echo "error";
        }
    }
}
