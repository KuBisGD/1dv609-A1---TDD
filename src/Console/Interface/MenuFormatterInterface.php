<?php

declare(strict_types=1);

namespace App\Tdd\Console\Interface;

use App\Tdd\Console\Menu;

interface MenuFormatterInterface
{
    public function format(Menu $menu): string;
}
