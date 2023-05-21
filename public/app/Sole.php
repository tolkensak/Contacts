<?php
namespace App;

trait Sole
{
    protected static ?self $inst=null;

    public static function inst() : self
    {
        if (is_null(self::$inst)) {
            self::$inst=new self;
        }

        return self::$inst;
    }
}
