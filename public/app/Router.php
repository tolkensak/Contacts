<?php
namespace App;

use App\Sole;
use App\Route;
use App\Session;

class Router
{
    use Sole;

    public readonly Route $activeRoute;
    protected array $routes=[];

    protected function __construct()
    {
        $this->add(new Route('signup', 'Регистрация', layout:'narrow'));
        $this->add(new Route('signin', 'Войти', layout:'narrow'));
        $this->add(new Route('signout', 'Выйти', permit:ROLE_ID_USER));
        $this->add(new Route('home', 'Главная', permit:ROLE_ID_USER, menuPos:1, script:'fav.js'));
        $this->add(new Route('fav', 'Избранное', permit:ROLE_ID_USER, menuPos:2, script:'fav.js'));
        $this->add(new Route('closed', 'Закрытой', permit:ROLE_ID_USER, menuPos:3));
        $this->add(new Route('nopage', '', permit:ROLE_ID_NONE|ROLE_ID_USER, layout:'narrow'));
        $this->add(new Route('favcount', '', permit:ROLE_ID_USER));

        $uniq=$_GET['route']??'';

        if ($uniq==='') {
            $uniq=Session::inst()->userid()===''?'signin':'home';
        }

        if (!array_key_exists($uniq, $this->routes)) {
            $uniq='nopage';
        }

        $this->activeRoute=$this->routes[$uniq];
    }

    public function add(Route $route)
    {
        $this->routes[$route->uniq]=$route;
    }

    public function get(string $uniq) : Route|null
    {
        if (array_key_exists($uniq, $this->routes)) {
            return $this->routes[$uniq];
        }

        return null;
    }

    public function walk(callable $callback) : void
    {
        foreach ($this->routes as $route) {
            $callback($route);
        }
    }
}
