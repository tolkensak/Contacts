<?php
namespace App\Controller;

use App\Contacts;
use App\Controller;

class Home extends Controller
{
    public function printView() : void
    {
        echo '<h1>Общий список контактов</h1>';

        Contacts::printList('contacts');
    }
}
