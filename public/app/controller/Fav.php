<?php
namespace App\Controller;

use App\Contacts;
use App\Controller;

class Fav extends Controller
{
    public function printView() : void
    {
        echo '<h1>Избранное контакты</h1>';

        Contacts::printList('usercontacts');
    }
}
