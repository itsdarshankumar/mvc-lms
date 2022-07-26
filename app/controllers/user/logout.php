<?php

namespace Controller;


class Logout
{
    public function get()
    {
        session_start();
        session_unset();
        session_destroy();
        header("Location: /");
        die();
    }
}