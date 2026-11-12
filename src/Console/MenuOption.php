<?php

declare(strict_types=1);

namespace App\Tdd\Console;

use BackedEnum;
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
     * @param string|BackedEnum<string> $selectValue
     * @param string $description
     * @param callable(): TReturn $callback
     */
    public function __construct(string|BackedEnum $selectValue, string $description, callable $callback)
    {
        $selectValueString = $selectValue instanceof BackedEnum ? $selectValue->value : $selectValue;
        if (strlen($selectValueString) < 1) {
            throw new InvalidArgumentException('select value must not be blank');
        }
        if (strlen($description) < 1) {
            throw new InvalidArgumentException('description must not be empty');
        }

        $this->selectValue = $selectValueString;
        $this->description = $description;
        $this->callback = Closure::fromCallable($callback);
    }

    /** @return TReturn */
    public function execute(): mixed
    {
        return call_user_func($this->callback);
    }
}
