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
        $username = $_SESSION["username"];
        if ($search) {
            $rows = \Postlogin\Dashboard::bookSearch($search);
        } elseif ($role) {
            $rows = \Postlogin\Admindashboard::adminDashboard();
        } else {
            $rows = \Postlogin\Dashboard::userDashboard($search);
            $myBooks=\Postlogin\Dashboard::myBooks($username);
        }
        if($role){
            echo \View\Loader::make()->render("templates/adminhome.twig", array(
                "books" => $rows,
                "role"  => $_SESSION["role"]
            ));
        }
        else{
        echo \View\Loader::make()->render("templates/home.twig", array(
            "books" => $rows,
            "role"  => $_SESSION["role"],
            "mybooks" => $myBooks
        ));}
    }
    
    public function post()
    {
        \Utils\Auth::userAuth();
        session_start();
        $_POST = json_decode(file_get_contents("php://input"), true);
        $bookid = $_POST["bookid"];
        $username = $_SESSION["username"];
        if (\Postlogin\Dashboard::bookAvailiability($bookid)) {
            if (\Postlogin\Dashboard::checkAvailiabilityForUser($username, $bookid)) {

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