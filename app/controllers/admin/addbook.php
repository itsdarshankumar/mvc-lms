<?php

namespace Controller;


class Adminadd
{
    public function post()
    {
        \Utils\Auth::adminAuth();
        $_POST = json_decode(file_get_contents("php://input"), true);
        $bookname = $_POST["bookname"];
        $number = $_POST["number"];
        $rows = \Postlogin\Dashboard::bookSearch($bookname);
        if ($rows) {
            $updatenumber = $number + $rows[0]["number"];
            if (\Postlogin\Admindashboard::updateBookNumber($updatenumber, $rows[0]["id"])) {
                echo "book added";
            } else {
                echo "some error in book addition";
            }
        } else {
            if ((\Postlogin\Admindashboard::addBook($bookname, $number))) {
                echo "book added";
            } else {
                echo "some error in book addition";
            }
        }
    }
}