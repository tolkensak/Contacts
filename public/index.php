<?php
namespace App;

require_once 'global.php';
require_once 'settings.php';

$sess=Session::inst();
$router=Router::inst();

$controller=new ("App\\Controller\\".$router->activeRoute->uniq);
$controller->processRequest();

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="<?php echo APP_TITLE; ?>">
    <meta name="robots" content="noindex, nofollow">
    <title><?php echo APP_TITLE; ?></title>
    <link type="image/x-icon" href="image/favicon.png" rel="icon">
    <link href="module/index.css" rel="stylesheet">
</head>
<body id="app">
<?php

    echo '<div id="app-banner">';
    echo '<div id="app-sign">';

    $fname=$sess->fname();

    echo ($fname==='')
        ? ('<a href="?route=signin">'.$router->get('signin')->title.'</a> / <a href="?route=signup">'.$router->get('signup')->title.'</a>')
        : ('<img class="user-icon" src="image/user.png"> <span>'.$fname.'</span> / <a href="?route=signout">'.$router->get('signout')->title.'</a>');

    echo '</div>';
    echo '<div id="app-logo">'.APP_TITLE.'</div>';
    echo '<div id="app-stack">PHP 8.2, MySQL 8.0</div>';
    echo '</div>';
    echo '<div id="app-nav">';

    $router->walk(function($route) use($sess) {
        if ($route->menuPos && $route->isPermitted($sess->roleid())) {
            echo '<a href="?route='.$route->uniq.'">'.$route->title.'</a>';
        }
    });

    echo '</div>';
    echo '<div id="app-body" class="'.$router->activeRoute->layout.'">';

    if ($router->activeRoute->isPermitted($sess->roleid())) {
        $controller->printView();
    }
    else {
        echo '<p>У вас нет разрешения</p>';
    }

    echo '</div>';

    if ($router->activeRoute->script!=='') {
        echo '<script src="module/'.$router->activeRoute->script.'"></script>';
    }

?>
</body>
</html>
