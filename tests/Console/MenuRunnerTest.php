<?php

declare(strict_types=1);

use App\Tdd\Console\Interface\Input;
use App\Tdd\Console\Interface\MenuFormatter;
use App\Tdd\Console\Interface\Output;
use App\Tdd\Console\Menu;
use App\Tdd\Console\MenuOption;
use App\Tdd\Console\MenuRunner;
use PHPUnit\Framework\TestCase;

final class MenuRunnerTest extends TestCase
{
    public function testCanBeCreatedWithMenuAndInterfaces(): void
    {
        [
            'formatter' => $formatter, 
            'input' => $input, 
            'output' =>$output
        ] = $this->createInterfaces();
        $menu = new Menu(new MenuOption('1', 'first 1', fn () => 'Hello world!'));
        $runner = new MenuRunner(menu: $menu, format: $formatter, input: $input, output: $output);

        $this->assertInstanceOf(MenuRunner::class, $runner);
    }

    private function createInterfaces(string $inputValue = ''): array
    {
        return [

            'input' => new class($inputValue) implements Input {
                public function __construct(private string $return) {}
                
                #[Override]
                public function read(): string
                {
                    return $this->return;
                }
            },

            'output' => new class implements Output {
                #[Override]
                public function write(string $string): void {}
            },

            'formatter' => new class implements MenuFormatter {
                #[Override]
                public function format(Menu $menu): string {
                    return '';
                }
            }

        ];
    }
}
