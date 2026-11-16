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
        $runner = new MenuRunner(menu: $menu, formatter: $formatter, input: $input, output: $output);

        $this->assertInstanceOf(MenuRunner::class, $runner);
    }

    public function testRunnerCanRenderTheMenu(): void
    {
        $outputString = '';
        [
            'formatter' => $formatter, 
            'input' => $input, 
            'output' => $output
        ] = $this->createInterfaces('1', writeTo: $outputString);

        $menu = new Menu(new MenuOption('1', 'first 1', fn () => 'Hello world!'));
        $runner = new MenuRunner(menu: $menu, formatter: $formatter, input: $input, output: $output);
        $runner->renderMenu();
        $this->assertEquals('1: first 1', $outputString);
    }

    private function createInterfaces(string $inputValue = '', string& $writeTo = ''): array
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

            'output' => new class($writeTo) implements Output {
                public string $output;

                public function __construct(string& $writeTo)
                {
                    $this->output =& $writeTo;
                }

                #[Override]
                public function write(string $string): void {
                    $this->output = $string;
                }
            },

            'formatter' => new class implements MenuFormatter {
                #[Override]
                public function format(Menu $menu): string {
                    $formatted = '';
                    foreach ($menu as $option) {
                        $formatted .= $option->selectValue . ': ' . $option->description;
                    }

                    return $formatted;
                }
            }

        ];
    }
}
