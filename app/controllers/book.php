<?php

namespace Controller;

class Book
{
    public function get()
    {
        \Utils\Auth::user();
        session_start();
        $search = $_GET['search'];
        $role = $_SESSION["role"];
        if ($search) {
            $rows = \Postlogin\Dashboard::bookSearch($search);
        } elseif ($role) {
            $rows = \Postlogin\Admindashboard::adminDashboard();
        } else {
            $rows = \Postlogin\Dashboard::userDashboard($search);
        }
        echo \View\Loader::make()->render("templates/home.twig", array(
            "books" => $rows,
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
        if (\Postlogin\Dashboard::bookAvailiability($bookid)) {
            if (\Postlogin\Dashboard::checkAvailiabilityforuser($username, $bookid)) {

                if (\Postlogin\Dashboard::checkout($username, $bookid)) {
                    echo "Checkout successfull";
                } else {
                    echo "error";
                }
            } else {
                echo "error";
            }
        } else {
            echo "error";
        }
    }
}
class History
{
    public function get()
    {
        session_start();
        $username = $_SESSION["username"];
        $rows = \Postlogin\Dashboard::userresolved($username);

        echo \View\Loader::make()->render("templates/history.twig", array(
            "history" => $rows
        ));
    }
}
