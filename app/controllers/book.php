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
        \Utils\Auth::userauth();
        $filter = $_GET['filter'];
        session_start();
        $username = $_SESSION["username"];
        if ($filter != NULL) {
            if ($filter != 3) {
                $rows = \Postlogin\Dashboard::userresolvedfilter($username, $filter);
            } else {
                $rows = \Postlogin\Dashboard::returnedBooks($username);
            }
        } else {
            $rows = \Postlogin\Dashboard::userresolved($username);
        }

        echo \View\Loader::make()->render("templates/history.twig", array(
            "history" => $rows
        ));
    }
}
class Returnrequest
{
    public function post()
    {
        \Utils\Auth::userauth();
        $_POST = json_decode(file_get_contents("php://input"), true);
        $id = $_POST["id"];
        \Postlogin\Dashboard::returnRequest($id);
        echo 'return requested';
    }
}
