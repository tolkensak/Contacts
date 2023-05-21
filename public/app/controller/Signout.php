<?php
namespace App\Controller;

use App\Sess;
use App\Controller;
use function App\redirect;

class Signout extends Controller
{
    public function processRequest() : void
    {
        Sess::inst()->signout();
        redirect('?');
    }
}
