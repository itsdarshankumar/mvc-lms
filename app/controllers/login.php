<?php

namespace Controller;

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
        $pass = $_POST["pass"];
        $rows = \Postlogin\Login::login($username, $pass);
        if ($rows) {
            session_start();
            $_SESSION["username"] = $username;
            $_SESSION["role"] = $rows[0]["role"];
            header("Location: /book");
            die();
        } else {
            echo "wrong credentials";
        }
    }
}
class Book
{
    public function get()
    {
        \Utils\Auth::user();
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
        \Utils\Auth::userauth();
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
        \Utils\Auth::adminauth();
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
        \Utils\Auth::adminauth();
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
        \Utils\Auth::adminauth();
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
class Adminhistory
{
    public function get()
    {
        \Utils\Auth::adminauth();
        $username = $_GET['username'];
        $rows = \Postlogin\Login::pastresolve($username);
        if ($rows) {
            echo \View\Loader::make()->render("templates/requests.twig", array(
                "requests" => $rows
            ));
        } else {
            echo "error in admin-user search";
        }
    }
}
class History
{
    public function get()
    {
        session_start();
        $username = $_SESSION["username"];
        $rows = \Postlogin\Login::userresolved($username);
        if ($rows) {
            echo \View\Loader::make()->render("templates/history.twig", array(
                "history" => $rows
            ));
        } else {
            echo "error in user-history";
        }
    }
}
class Adminupdate
{
    public function post()
    {
        \Utils\Auth::adminauth();
        $_POST = json_decode(file_get_contents("php://input"), true);
        $id = $_POST["id"];
        $avail = $_POST["avail"];
        if (\Postlogin\Login::updatebooks($id, $avail)) {
            echo "book state changed";
        } else {
            echo "error in changing state";
        }
    }
}
class Adminreturn
{
    public function post()
    {
        \Utils\Auth::adminauth();
        $_POST = json_decode(file_get_contents("php://input"), true);
        $id = $_POST["id"];
        $bookid = $_POST["bookid"];
        if (\Postlogin\Login::returnbooks($id, $bookid)) {
            echo "returned";
        } else {
            echo "error in returning";
        }
    }
}
class Signup
{
    public function get()
    {
        echo \View\Loader::make()->render("templates/sign-up.twig");
    }
    public function post()
    {
        $username = $_POST["username"];
        $pass = $_POST["pass"];
        $pass_repeat = $_POST["pass_repeat"];
        $email = $_POST["email"];
        if (\Postlogin\Login::signupentry($username, $email, $pass, $pass_repeat)) {
            header("Location: /");
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
