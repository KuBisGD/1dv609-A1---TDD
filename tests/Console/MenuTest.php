<?php

declare(strict_types=1);

use App\Tdd\Console\MenuOption;
use App\Tdd\Console\Menu;
use PHPUnit\Framework\TestCase;

final class MenuTest extends TestCase
{
    public function testMenuCanBeCreatedWithOptions(): void
    {
        $menu = new Menu(...$this->createMenuOptionArray(optionCount: 2));

        $this->assertInstanceOf(Menu::class, $menu);
    }

    public function testMenuShouldBeCountableForOptionCount(): void
    {
        $optionCount = 2;

        $menu = new Menu(...$this->createMenuOptionArray($optionCount));

        $this->assertInstanceOf(Countable::class, $menu);

        $this->assertEquals($optionCount, count($menu));
    }

    public function testMenuShouldNotBeCreatedWithNoOptions(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $menu = new Menu();
    }

    public function testMenuShouldProvideOptionFromSelectValue(): void
    {
        $options = $this->createMenuOptionArray(3);
        $firstOption = array_first($options);
        $lastOption = array_last($options);

        $menu = new Menu(...$options);

        $first = $menu->getOption('1');
        $last = $menu->getOption('3');

        $this->assertSame($firstOption, $first);
        $this->assertSame($lastOption, $last);
    }

    public function testMenuThrowsIfGettingInvalidOption(): void
    {
        $menu = new Menu(...$this->createMenuOptionArray(optionCount: 2));

        $this->expectException(InvalidArgumentException::class);

        (void) $menu->getOption('3');
    }

    public function testGetOptionReturnShouldNotBeIgnored(): void
    {
        $method = new ReflectionMethod(Menu::class, 'getOption');

        $this->assertNotEmpty(
            $method->getAttributes(NoDiscard::class), 
            message: Menu::class.'::getOption() return value must not be able to be discarded'
        );
    }

    public function testMenuIsIterableOverItsOptions(): void
    {
        $options = $this->createMenuOptionArray(optionCount: 10);
        $menu = new Menu(...$options);
        
        $this->assertIsIterable($menu);
        $this->assertArraysHaveIdenticalValues($options, iterator_to_array($menu));
    }

    public function testMenuShouldNotHaveOptionWithDuplicateSelectValues(): void
    {
        $option = new MenuOption('1', '1', fn () => '1');

        $this->expectException(InvalidArgumentException::class);
        new Menu($option, $option);
    }

    private function createMenuOptionArray(int $optionCount): array
    {
        $options = [];
        foreach (range(1, $optionCount) as $i) {
            $countString = (string) $i;
            $options[] = new MenuOption($countString, 'description_'.$countString, fn () => 'call_'.$countString);
        }

        return $options;
    }
}

