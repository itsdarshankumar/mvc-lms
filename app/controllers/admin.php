<?php

namespace Controller;

class Admin
{
    public function get()
    {
        \Utils\Auth::adminauth();
        $rows = \Postlogin\Admindashboard::bookapprovalrender();

            echo \View\Loader::make()->render("templates/requests.twig", array(
                "requests" => $rows
            ));
        
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
        if ($status == 1) {
            $rows = \Postlogin\Admindashboard::bookSearchbyid($bookid);
            if ($rows[0]["number"] == 1) {
                \Postlogin\Admindashboard::finishedBook($bookid);
            } else {
                \Postlogin\Admindashboard::updateBooknumber($rows[0]["number"] - 1, $bookid);
            }
        }
        if (\Postlogin\Admindashboard::requestResolve($id, $status, $username)) {
            echo "resolved";
        } else {
            echo "error in resolving";
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
        $rows = \Postlogin\Dashboard::bookSearch($bookname);
        if ($rows) {
            $updatenumber = $number + $rows[0]["number"];
            if (\Postlogin\Admindashboard::updateBooknumber($updatenumber, $rows[0]["id"])) {
                echo "book added";
            } else {
                echo "some error in book addition";
            }
        } else {
            if ((\Postlogin\Admindashboard::addbook($bookname, $number))) {
                echo "book added";
            } else {
                echo "some error in book addition";
            }
        }
    }
}

class Adminhistory
{
    public function get()
    {
        \Utils\Auth::adminauth();
        $username = $_GET['username'];
        $rows = \Postlogin\Admindashboard::pastresolve($username);
        if ($rows) {
            echo \View\Loader::make()->render("templates/requests.twig", array(
                "requests" => $rows
            ));
        } else {
            echo "error in admin-user search";
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
        if (\Postlogin\Admindashboard::updatebooks($id, $avail)) {
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
        $rows = \Postlogin\Admindashboard::bookSearchbyid($bookid);
        if ($rows[0]["number"] == 0) {
            \Postlogin\Admindashboard::updateFinishedbook($rows[0]["number"] + 1, $bookid);
        } else {
            \Postlogin\Admindashboard::updateBooknumber($rows[0]["number"] + 1, $bookid);
        }
        if (\Postlogin\Admindashboard::returnbooks($id)) {
            echo "returned";
        } else {
            echo "error in returning";
        }
    }
}
