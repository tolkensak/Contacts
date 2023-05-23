<?php
namespace App;

spl_autoload_register(function (string $className) {
    if ($className=='App\\Connection\\Data') {
        include '../include/'.APP_UNIQ.'.php';
    }
    else {
        include $className.'.php';
    }
});
