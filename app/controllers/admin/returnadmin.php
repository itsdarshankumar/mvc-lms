<?php

namespace Controller;


class Adminreturn
{
    public function post()
    {
        \Utils\Auth::adminAuth();
        $_POST = json_decode(file_get_contents("php://input"), true);
        $id = $_POST["id"];
        $bookid = $_POST["bookid"];
        $rows = \Postlogin\Admindashboard::bookSearchbyId($bookid);
        if ($rows[0]["number"] == 0) {
            \Postlogin\Admindashboard::updateFinishedBook($rows[0]["number"] + 1, $bookid);
        } else {
            \Postlogin\Admindashboard::updateBookNumber($rows[0]["number"] + 1, $bookid);
        }
        if (\Postlogin\Admindashboard::returnBooks($id)) {
            echo "returned";
        } else {
            echo "error in returning";
        }
    }
}
