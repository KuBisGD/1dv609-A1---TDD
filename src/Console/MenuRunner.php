<?php

declare(strict_types=1);

namespace App\Tdd\Console;

use App\Tdd\Console\Interface\Input;
use App\Tdd\Console\Interface\MenuFormatter;
use App\Tdd\Console\Interface\Output;

final class MenuRunner
{
    public function __construct(Menu $menu, MenuFormatter $formatter, Input $input, Output $output)
    {
        
    }
}
