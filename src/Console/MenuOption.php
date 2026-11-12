<?php

declare(strict_types=1);

namespace App\Tdd\Console;

final class MenuOption
{
    public private(set) string $description;

    public function __construct(string $selectValue, string $description, callable $callback)
    {
        $this->description = $description;
    }    
}
