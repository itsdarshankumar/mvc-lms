<?php

namespace Controller;


class Returnrequest
{
    public function post()
    {
        \Utils\Auth::userAuth();
        $_POST = json_decode(file_get_contents("php://input"), true);
        $id = $_POST["id"];
        \Postlogin\Dashboard::returnRequest($id);
        echo 'return requested';
    }
}
