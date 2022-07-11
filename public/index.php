<?php

require __DIR__."/../vendor/autoload.php";

Toro::serve(array(
    "/" => "\Controller\Login",
    "/book" => "\Controller\Book"
));
