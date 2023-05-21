<?php
namespace App\Controller;

use App\Sess;
use App\Controller;

class Closed extends Controller
{
    public function printView() : void
    {
        echo '<h1>Закрытой части</h1>';
        echo '<p>Закрытой части проекта, доступной только после авторизации</p>';
    }
}
