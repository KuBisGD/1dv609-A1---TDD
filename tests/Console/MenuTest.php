<?php

declare(strict_types=1);

use App\Tdd\Console\MenuOption;
use App\Tdd\Console\Menu;
use PHPUnit\Framework\TestCase;

final class MenuTest extends TestCase
{
    public function testMenuCanBeCreatedWithOptions(): void
    {
        $menu = new Menu(
            new MenuOption('1', 'des1', fn () => 'call1'),
            new MenuOption('2', 'des2', fn () => 'call2'),
        );

        $this->assertInstanceOf(Menu::class, $menu);
    }

    public function testMenuShouldBeCountableForOptionCount(): void
    {
        $optionCount = 2;

        $menu = new Menu(
            new MenuOption('1', 'des1', fn () => 'call1'),
            new MenuOption('2', 'des2', fn () => 'call2'),
        );

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
        $firstMenu = new MenuOption('1', 'des1', fn () => 'call1');
        $lastMenu = new MenuOption('3', 'des2', fn () => 'call3');

        $menu = new Menu(
            $firstMenu,
            new MenuOption('2', 'des2', fn () => 'call2'),
            $lastMenu
        );

        $first = $menu->getOption('1');
        $last = $menu->getOption('3');

        $this->assertSame($firstMenu, $first);
        $this->assertSame($lastMenu, $last);
    }
}

