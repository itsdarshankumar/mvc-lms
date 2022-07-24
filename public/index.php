<?php

require __DIR__ . "/../vendor/autoload.php";

Toro::serve(array(
    "/" => "\Controller\Login",
    "/book" => "\Controller\Book",
    "/book/admin/add" => "\Controller\Adminadd",
    "/book/admin" => "\Controller\Admin",
    "/book/admin/history" => "\Controller\Adminhistory",
    "/book/history" => "\Controller\History",
    "/book/admin/update" => "\Controller\Adminupdate",
    "/book/admin/return" => "\Controller\Adminreturn",
    "/signup" => "\Controller\Signup",
    "/logout" => "\Controller\Logout",
    "/book/return" => "\Controller\Returnrequest"
));
