<?php

declare(strict_types=1);

namespace App\Tdd\Console;

use Countable;
use Override;

final class Menu implements Countable
{
    private array $options;

    public function __construct(MenuOption ...$options)
    {
        $this->options = $options;
    }

    #[Override]
    public function count(): int
    {
        return count($this->options);
    }
}
