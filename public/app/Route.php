<?php
namespace App;

class Route
{
    public function __construct(
        public readonly string $uniq='',
        public readonly string $title='',
        public readonly int $permit=ROLE_ID_NONE,
        public readonly int $menuPos=0,
        public readonly string $layout='',
        public readonly string $script='',
    ) {}

    public function isPermitted(int $permit) : bool
    {
        return $this->permit & $permit;
    }
}
