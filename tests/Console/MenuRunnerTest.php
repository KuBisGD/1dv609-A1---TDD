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
        $menu = new Menu(new MenuOption('1', 'first 1', fn () => 'Hello world!'));
        $runner = new MenuRunner(
            menu: $menu, 
            formatter: $this->createStub(MenuFormatter::class), 
            input: $this->createStub(Input::class), 
            output: $this->createStub(Output::class)
        );

        $this->assertInstanceOf(MenuRunner::class, $runner);
    }

    public function testRunnerCanRenderTheMenu(): void
    {
        $expectedFormat = '1: first 1';

        $menu = new Menu(new MenuOption('1', 'first 1', fn () => 'Hello world!'));
        $runner = new MenuRunner(
            menu: $menu, 
            formatter: $this->getFormatterMock($expectedFormat), 
            input: $this->getInputStub('any'), 
            output: $this->getOutputMock(calledWith: $expectedFormat)
        );
        $runner->renderMenu();
    }

    private function getInputStub(string $inputReturnValue): Input
    {
        $mock = $this->createStub(Input::class);
        $mock->method('read')->willReturn($inputReturnValue);
        return $mock;
    }

    private function getOutputMock(string $calledWith): Output
    {
        $mock = $this->createMock(Output::class);
        $mock->expects($this->once())
            ->method('write')
            ->with($calledWith);
        return $mock;
    }

    private function getFormatterMock(string $formatReturn): MenuFormatter
    {
        $mock = $this->createMock(MenuFormatter::class);
        $mock->expects($this->once())
            ->method('format')
            ->willReturn($formatReturn);
        return $mock;
    }

    private function createInterfaces(string $inputValue = '', string& $writeTo = ''): array
    {
        return [

            'input' => $this->getInputStub($inputValue),

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
