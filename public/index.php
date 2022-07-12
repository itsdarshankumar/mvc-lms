<?php

require __DIR__."/../vendor/autoload.php";

Toro::serve(array(
    "/" => "\Controller\Login",
    "/book" => "\Controller\Book",
    "/book/admin/add" => "\Controller\Adminadd",
    "/book/admin"=>"\Controller\Admin"
));
