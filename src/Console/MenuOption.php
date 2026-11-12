<?php

declare(strict_types=1);

namespace App\Tdd\Console;

use Closure;
use InvalidArgumentException;

/**
 * @template TReturn
 */
final class MenuOption
{
    public private(set) string $selectValue;
    public private(set) string $description;
    private Closure $callback;

    /**
     * Creates a new MenuOption.
     *
     * @param string $selectValue
     * @param string $description
     * @param callable(): TReturn $callback
     */
    public function __construct(string $selectValue, string $description, callable $callback)
    {
        if (strlen($selectValue) < 1) {
            throw new InvalidArgumentException('select value must not be blank');
        }

        $this->selectValue = $selectValue;
        $this->description = $description;
        $this->callback = Closure::fromCallable($callback);
    }

    /** @return TReturn */
    public function execute(): mixed
    {
        return call_user_func($this->callback);
    }
}
