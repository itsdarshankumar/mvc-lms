<?php

namespace Controller;


abstract class Filter {
    const Rejected	= 0;
    const Accepted 	= 1;
    const Pending	= 2;
    const Returned 	= 3;
}

class History
{
    public function get()
    {
        \Utils\Auth::userAuth();
        $filter = $_GET['filter'];
        session_start();
        $username = $_SESSION["username"];

        
        if ($filter != NULL) {
            if ($filter != \Controller\Filter :: Returned) {
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