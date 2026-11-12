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
}