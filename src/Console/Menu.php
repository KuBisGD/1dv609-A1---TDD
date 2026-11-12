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

        foreach ($options as $option) {
            $this->options[$option->selectValue] = $option;
        }
    }

    public function getOption(string $selectValue): MenuOption
    {
        return $this->options[$selectValue];
    }

    #[Override]
    public function count(): int
    {
        return count($this->options);
    }
}
