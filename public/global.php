<?php
namespace App;

const APP_TITLE='Контакты';
const APP_UNIQ='contacts';

const ROLE_ID_NONE=1;
const ROLE_ID_USER=2;

function redirect(string $url) : never
{
    ob_start();
    header('Location: '.$url);
    ob_end_flush();
    exit;
}

function hsc(string $str) : string
{
    return htmlspecialchars($str, ENT_QUOTES|ENT_SUBSTITUTE, 'UTF-8');
}
