<?php

namespace Postlogin;

use Bcrypt\Bcrypt;

class Login
{
    public static function login($username, $pass)
    {
        $bcrypt = new Bcrypt();
        $db = \DB::get_instance();
        $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $rows = $stmt->fetchAll();
        if ($rows) {
            if ($bcrypt->verify($pass, $rows[0]["pass"])) {
                return $rows;
            }
        }
        return false;
    }

    public static function get_all($role = 0, $search = NULL,)
    {
        $db = \DB::get_instance();
        if ($search) {
            $stmt = $db->prepare("SELECT * FROM books WHERE bookname = ?");
            $stmt->execute([$search]);
        } elseif ($role) {
            $stmt = $db->prepare("SELECT * FROM books ORDER BY id DESC");
            $stmt->execute();
        } else {
            $stmt = $db->prepare("SELECT * FROM books WHERE avail = 1 ORDER BY id DESC");
            $stmt->execute();
        }
        $rows = $stmt->fetchAll();
        return $rows;
    }

    public static function checkout($username, $bookid)
    {
        $db = \DB::get_instance();
        $stmt = $db->prepare("SELECT * FROM books WHERE id = ? AND avail=1");
        $stmt->execute([$bookid]);
        if ($stmt->fetch()) {
            $stmt = $db->prepare("SELECT * FROM requests WHERE username=? AND returned = 0 AND bookid=? AND (status=1 OR status=2)");
            $stmt->execute([$username, $bookid]);
            if ($stmt->fetchAll()) {
                return false;
            } else {
                $stmt = $db->prepare("INSERT INTO requests(bookid,username,status,returned) VALUES(?,?,2,0)");
                $stmt->execute([$bookid, $username]);
                return true;
            }
        }
        return false;
    }
    public static function addbook($bookname, $number)
    {
        $db = \DB::get_instance();
        $stmt = $db->prepare("SELECT * FROM books WHERE bookname=?");
        $stmt->execute([$bookname]);
        $rows = $stmt->fetchAll();
        if ($rows) {
            $updatenumber = $number+ $rows[0]["number"];
            $stmt = $db->prepare("UPDATE books SET number=? WHERE bookname=?");
            $stmt->execute([$updatenumber, $bookname]);
            return false;
        }
        else{
            $stmt=$db->prepare("INSERT INTO books (bookname,number,avail) VALUES(?,?,1)");
            $stmt->execute([$bookname,$number]);
            return true;
        }
    }
    public static function bookapprovalrender(){
        $db = \DB::get_instance();
        $stmt = $db->prepare("SELECT * FROM requests WHERE status=2");
        $stmt->execute();
        $rows=$stmt->fetchAll();
        return $rows;
    }
    public static function bookresolve($id,$status,$bookid,$username){
        $db = \DB::get_instance();
        if($status == 1){
            $stmt=$db->prepare("SELECT * FROM books WHERE id=?");
            $stmt->execute([$bookid]);
            $rows=$stmt->fetchAll();
            if($rows[0]["number"]==1){
                $stmt=$db->prepare("UPDATE books SET number=?,avail=0 WHERE id=?");
                $stmt->execute([$rows[0]["number"]-1,$bookid]);
            }
            else{
                $stmt=$db->prepare("UPDATE books SET number=? WHERE id=?");
                $stmt->execute([$rows[0]["number"]-1,$bookid]);
            }
        }
        $stmt=$db->prepare("UPDATE requests SET status=?,resolveby=?,returned=0 WHERE id=?");
        $stmt->execute([$status,$username,$id]);
        return true;
    }
}
