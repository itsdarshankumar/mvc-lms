<?php

namespace Postlogin;

class Admindashboard
{
    public static function adminDashboard()
    {
        $db = \DB::get_instance();
        $stmt = $db->prepare("SELECT * FROM books ORDER BY id DESC");
        $stmt->execute();
        $rows = $stmt->fetchAll();
        return $rows;
    }
    public static function updatebooks($id, $avail)
    {
        $db = \DB::get_instance();
        $stmt = $db->prepare("UPDATE books SET avail=? WHERE id=?");
        $stmt->execute([$avail, $id]);
        return true;
    }
    public static function returnbooks($id)
    {
        $db = \DB::get_instance();
        $stmt = $db->prepare("UPDATE requests SET returned=1 WHERE id=?");
        $stmt->execute([$id]);
        return true;
    }
    public static function updateFinishedbook($number, $bookid)
    {
        $db = \DB::get_instance();
        $stmt = $db->prepare("UPDATE books SET number=?,avail=1 WHERE id=?");
        $stmt->execute([$number, $bookid]);
    }
    public static function updateBooknumber($number, $bookid)
    {
        $db = \DB::get_instance();
        $stmt = $db->prepare("UPDATE books SET number=? WHERE id=?");
        $stmt->execute([$number, $bookid]);
        return true;
    }
    public static function bookSearchbyid($bookid)
    {
        $db = \DB::get_instance();
        $stmt = $db->prepare("SELECT * FROM books WHERE id=?");
        $stmt->execute([$bookid]);
        $rows = $stmt->fetchAll();
        return $rows;
    }
    public static function addbook($bookname, $number)
    {
        $db = \DB::get_instance();
        $stmt = $db->prepare("INSERT INTO books (bookname,number,avail) VALUES(?,?,1)");
        $stmt->execute([$bookname, $number]);
        return true;
    }

    public static function bookapprovalrender()
    {
        $db = \DB::get_instance();
        $stmt = $db->prepare("SELECT requests.bookid,requests.username,requests.status,requests.returned,books.bookname,requests.id  FROM requests INNER JOIN books ON requests.bookid=books.id WHERE requests.status=2 OR (requests.status=1 AND requests.returned=2)");
        $stmt->execute();
        $rows = $stmt->fetchAll();
        return $rows;
    }

    public static function finishedBook($bookid)
    {
        $db = \DB::get_instance();
        $stmt = $db->prepare("UPDATE books SET number=?,avail=0 WHERE id=?");
        $stmt->execute([0, $bookid]);
        return true;
    }
    public static function requestResolve($id, $status, $username)
    {
        $db = \DB::get_instance();
        $stmt = $db->prepare("UPDATE requests SET status=?,resolveby=?,returned=0 WHERE id=?");
        $stmt->execute([$status, $username, $id]);
        return true;
    }
    public static function pastresolve($username)
    {
        $db = \DB::get_instance();
        $stmt = $db->prepare("SELECT requests.bookid,requests.username,requests.status,requests.returned,books.bookname,requests.id  FROM requests INNER JOIN books ON requests.bookid=books.id WHERE requests.username=? ORDER BY requests.id DESC");
        $stmt->execute([$username]);
        $rows = $stmt->fetchAll();
        return $rows;
    }
}
