<?php

namespace Controller;


class Adminhistory
{
    public function get()
    {
        \Utils\Auth::adminAuth();
        $username = $_GET['username'];
        $rows = \Postlogin\Admindashboard::pastResolve($username);
        if ($rows) {
            echo \View\Loader::make()->render("templates/requests.twig", array(
                "requests" => $rows
            ));
        } else {
            echo "error in admin-user search";
        }
    }
}