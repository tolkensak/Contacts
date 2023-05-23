<?php
namespace App\Controller;

use App\Session;
use App\Connection;
use App\Controller;

class FavCount extends Controller
{
    public function processRequest() : void
    {
        $contactid=$_GET['contactid'];
        $fav=$_GET['fav'];

        Connection::inst()->query('call sp_fav('.Session::inst()->userid().', '.$contactid.', '.$fav.')');
        exit;
   }
}
