<?php

declare(strict_types=1);

namespace App\Tdd\Console\Interface;

interface Input
{
    public function read(): string;
}
