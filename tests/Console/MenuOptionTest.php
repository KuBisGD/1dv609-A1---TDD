<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Tdd\Console\MenuOption;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;

enum SelectValue: string
{
    case PASSING_VALUE = 'test';
}

#[CoversClass(MenuOption::class)]
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

    public static function constructorProvider(): array
    {
        $callable = fn () => self::CALLBACK_RETURN;
        return [
            'empty selectValue throws exception' => ['', self::DESCRIPTION, $callable],
            'empty description throws exception' => [self::SELECT_VALUE, '', $callable],
        ];
    }

    #[DataProvider('constructorProvider')]
    public function testInvalidConstructorArgumentThrows(string $selectValue, string $description, callable $callable): void
    {
        $this->expectException(InvalidArgumentException::class);
        $option = new MenuOption($selectValue, $description, $callable);
    }

    public function testSelectValueCanBeBackedEnum(): void
    {
        $selectValue = SelectValue::PASSING_VALUE;
        $option = new MenuOption($selectValue, self::DESCRIPTION, fn () => self::CALLBACK_RETURN);

        $this->assertEquals($selectValue->value, $option->selectValue);
    }

    private function createDefaultOption(): MenuOption
    {
        return new MenuOption(selectValue: self::SELECT_VALUE, description: self::DESCRIPTION, callback: fn () => self::CALLBACK_RETURN);
    }
}
