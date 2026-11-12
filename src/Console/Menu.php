<?php

declare(strict_types=1);

namespace App\Tdd\Console;

use ArrayIterator;
use Countable;
use InvalidArgumentException;
use IteratorAggregate;
use NoDiscard;
use Override;
use Traversable;

final class Menu implements Countable, IteratorAggregate
{
    /**
     * @var array<string, MenuOption>
     */
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

    #[NoDiscard]
    public function getOption(string $selectValue): MenuOption
    {
        if (! isset($this->options[$selectValue])) {
            throw new InvalidArgumentException('option for selectValue of: ' . $selectValue . ' does not exist on this menu');
        }

        return $this->options[$selectValue];
    }

    #[Override]
    public function count(): int
    {
        return count($this->options);
    }

    /**
     * @return Traversable<string, MenuOption>
     */
    #[Override]
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->options);
    }
}
