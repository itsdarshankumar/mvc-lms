<?php

namespace Controller;


class Admin
{
    public function get()
    {
        \Utils\Auth::adminAuth();
        $rows = \Postlogin\Admindashboard::bookApprovalRender();

            echo \View\Loader::make()->render("templates/requests.twig", array(
                "requests" => $rows
            ));
        
    }

    public function post()
    {
        \Utils\Auth::adminAuth();
        $_POST = json_decode(file_get_contents("php://input"), true);
        $id = $_POST["id"];
        $status = $_POST["status"];
        $bookid = $_POST["bookid"];
        session_start();
        $username = $_SESSION["username"];
        if ($status == 1) {
            $rows = \Postlogin\Admindashboard::bookSearchbyId($bookid);
            if ($rows[0]["number"] == 1) {
                \Postlogin\Admindashboard::finishedBook($bookid);
            } else {
                \Postlogin\Admindashboard::updateBookNumber($rows[0]["number"] - 1, $bookid);
            }
        }
        if (\Postlogin\Admindashboard::requestResolve($id, $status, $username)) {
            echo "resolved";
        } else {
            echo "error in resolving";
        }
    }
}