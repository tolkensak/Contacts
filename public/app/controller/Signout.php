<?php
namespace App\Controller;

use App\Session;
use App\Controller;
use function App\redirect;

class Signout extends Controller
{
    public function processRequest() : void
    {
        Session::inst()->signout();
        redirect('?');
    }
}
