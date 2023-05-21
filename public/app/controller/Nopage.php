<?php
namespace App\Controller;

use App\Sess;
use App\Controller;

class Nopage extends Controller
{
    public function printView() : void
    {
        echo '<p>Нет такой страницы</p>';
    }
}
