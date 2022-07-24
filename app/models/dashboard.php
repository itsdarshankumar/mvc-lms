<?php

namespace Postlogin;

class Dashboard
{
    public static function userDashboard($search = NULL,)
    {
        $db = \DB::get_instance();

        $stmt = $db->prepare("SELECT * FROM books WHERE avail = 1 ORDER BY id DESC");
        $stmt->execute();

        $rows = $stmt->fetchAll();
        return $rows;
    }

    public static function bookSearch($search)
    {
        $db = \DB::get_instance();
        $stmt = $db->prepare("SELECT * FROM books WHERE bookname LIKE CONCAT( ?,'%')");
        $stmt->execute([$search]);
        $rows = $stmt->fetchAll();
        return $rows;
    }


    public static function checkout($username, $bookid)
    {
        $db = \DB::get_instance();
        $stmt = $db->prepare("INSERT INTO requests(bookid,username,status,returned) VALUES(?,?,2,0)");
        $stmt->execute([$bookid, $username]);
        return true;
    }
    public static function bookAvailiability($bookid)
    {
        $db = \DB::get_instance();
        $stmt = $db->prepare("SELECT * FROM books WHERE id = ? AND avail=1");
        $stmt->execute([$bookid]);
        if ($stmt->fetchAll()) {
            return true;
        }
        return false;
    }
    public static function checkAvailiabilityforuser($username, $bookid)
    {
        $db = \DB::get_instance();
        $stmt = $db->prepare("SELECT * FROM requests WHERE username=? AND returned = 0 AND bookid=? AND (status=1 OR status=2)");
        $stmt->execute([$username, $bookid]);
        if ($stmt->fetchAll()) {
            return false;
        }
        return true;
    }


    public static function userresolved($username)
    {
        $db = \DB::get_instance();
        $stmt = $db->prepare("SELECT requests.bookid,requests.username,requests.status,requests.returned,books.bookname FROM requests INNER JOIN books ON requests.bookid=books.id WHERE username=? ORDER BY requests.id DESC");
        $stmt->execute([$username]);
        $rows = $stmt->fetchAll();
        return $rows;
    }
}
