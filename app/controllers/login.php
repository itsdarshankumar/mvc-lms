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
        $rows = \Postlogin\Login::login($username, $pass);
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
        session_start();
        $search = $_GET['search'];
        $role = $_SESSION["role"];
        echo \View\Loader::make()->render("templates/home.twig", array(
            "books" => \Postlogin\Login::get_all($role, $search),
            "role"  => $_SESSION["role"]
        ));
    }
    public function post()
    {
        session_start();
        $_POST = json_decode(file_get_contents("php://input"), true);
        $bookid = $_POST["bookid"];
        $username = $_SESSION["username"];
        if (\Postlogin\Login::checkout($username, $bookid)) {
            echo "Checkout successfull";
        } else {
            echo "error";
        }
    }
}
class Adminadd
{
    public function post()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $bookname = $_POST["bookname"];
        $number = $_POST["number"];
        if (\Postlogin\Login::addbook($bookname, $number)) {
            echo "book added";
        } else {
            echo "some error in book addition";
        }
    }
}
class Admin
{
    public function get()
    {
        $rows = \Postlogin\Login::bookapprovalrender();
        if ($rows) {
            echo \View\Loader::make()->render("templates/requests.twig", array(
                "requests" => $rows
            ));
        } else {
            echo "error in loading admin requests";
        }
    }

    public function post()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $id = $_POST["id"];
        $status = $_POST["status"];
        $bookid = $_POST["bookid"];
        session_start();
        $username = $_SESSION["username"];
        if (\Postlogin\Login::bookresolve($id, $status, $bookid, $username)) {
            echo "resolved";
        } else {
            echo "error in resolving";
        }
    }
}
