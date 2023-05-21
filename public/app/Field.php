<?php
namespace App;

class Field
{
    public string $value='';
    public string $error='';

    public function __construct
    (
        public readonly string $name='',
    ) {}

    public function isValid() : bool
    {
        return $this->error==='';
    }

    public function testForEmpty() : bool
    {
        if ($this->value==='') {
            $this->error='Это обязательное поле!';
            return false;
        }

        return true;
    }
}
