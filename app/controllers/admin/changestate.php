<?php

namespace Controller;



class Adminupdate
{
    
    public function post()
    {
        \Utils\Auth::adminAuth();
        $_POST = json_decode(file_get_contents("php://input"), true);
        $id = $_POST["id"];
        $avail = $_POST["avail"];
        $rows=\Postlogin\Admindashboard::bookSearchbyId($id);
        if($rows[0]['number'] != 0){
        if (\Postlogin\Admindashboard::updateBooks($id, $avail)) {
            echo "book state changed";
        } else {
            echo "error";
        }
    }
    else{
        echo "error";
    }
    }
}