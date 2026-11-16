<?php

declare(strict_types=1);

namespace App\Tdd\Console\Interface;

interface Output
{
    public function write(string $string): void;
}
