<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Tdd\Console\MenuOption;

final class MenuOptionTest extends TestCase
{
    private const String SELECT_VALUE = '1';
    private const String DESCRIPTION = 'des';
    private const String CALLBACK_RETURN = 'Hello World';

    public function testCanBeCreatedWithValidArguments(): void
    {
        $option = $this->createDefaultOption();

        $this->assertInstanceOf(MenuOption::class, $option);
    }

    public function testOptionHasDescription(): void
    {
        $option = $this->createDefaultOption();

        $this->assertEquals(self::DESCRIPTION, $option->description);
    }

    public function testOptionHasSelectValue(): void
    {
        $option = $this->createDefaultOption();

        $this->assertEquals(self::SELECT_VALUE, $option->selectValue);
    }

    public function testOptionCanExecuteProvidedCallable(): void
    {
        $option = $this->createDefaultOption();

        $return = $option->execute();

        $this->assertEquals(self::CALLBACK_RETURN, $return);
    }

    private function createDefaultOption(): MenuOption
    {
        return new MenuOption(selectValue: self::SELECT_VALUE, description: self::DESCRIPTION, callback: fn () => self::CALLBACK_RETURN);
    }
}
