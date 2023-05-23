<?php
namespace App;

use App\Sole;

class Session
{
    use Sole;

    protected function __construct()
    {
        if (!session_id()) {
            session_name(APP_UNIQ);
            session_start();
        }
    }

    public function userid() : string
    {
        return $_SESSION['userid']??'';
    }

    public function fname() : string
    {
        return $_SESSION['fname']??'';
    }

    public function roleid() : int
    {
        return (int)($_SESSION['roleid']??ROLE_ID_NONE);
    }

    public function signin(string $userid, string $fname) : void
    {
        $_SESSION['userid']=$userid;
        $_SESSION['fname']=$fname;
        $_SESSION['roleid']=ROLE_ID_USER;
    }

    public function signout() : void
    {
        unset($_SESSION['userid']);
        unset($_SESSION['fname']);
        unset($_SESSION['roleid']);
    }
}
