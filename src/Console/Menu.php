<?php

declare(strict_types=1);

namespace App\Tdd\Console;

use Countable;
use InvalidArgumentException;
use Override;

final class Menu implements Countable
{
    private array $options;

    public function __construct(MenuOption ...$options)
    {
        if (count($options) < 1) {
            throw new InvalidArgumentException('menu must contain at leas one option');
        }

        $this->options = $options;
    }

    #[Override]
    public function count(): int
    {
        return count($this->options);
    }
}
