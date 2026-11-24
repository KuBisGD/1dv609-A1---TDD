<?php

declare(strict_types=1);

namespace App\Tdd\Console\Interface;

interface InputInterface
{
    public function read(): string;
}
