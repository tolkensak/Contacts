<?php
namespace App\Controller;

use App\Sess;
use App\Conn;
use App\Controller;

class FavCount extends Controller
{
    public function processRequest() : void
    {
        $contactid=$_GET['contactid'];
        $fav=$_GET['fav'];

        Conn::inst()->query('call sp_fav('.Sess::inst()->userid().', '.$contactid.', '.$fav.')');
        exit;
   }
}
