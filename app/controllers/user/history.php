<?php

namespace Controller;


class History
{
    public function get()
    {
        \Utils\Auth::userAuth();
        $filter = $_GET['filter'];
        session_start();
        $username = $_SESSION["username"];
        if ($filter != NULL) {
            if ($filter != 3) {
                $rows = \Postlogin\Dashboard::userResolvedFilter($username, $filter);
            } else {
                $rows = \Postlogin\Dashboard::returnedBooks($username);
            }
        } else {
            $rows = \Postlogin\Dashboard::userResolved($username);
        }

        echo \View\Loader::make()->render("templates/history.twig", array(
            "history" => $rows
        ));
    }
}