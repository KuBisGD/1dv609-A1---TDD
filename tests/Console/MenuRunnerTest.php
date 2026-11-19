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

    public function testOptionCanBeSelectedFromInput(): void
    {   
        $expectedReturn = 'Hello world_3';
        $option = $this->createMock(MenuOption::class);
        $option->__construct('3', 'first 3', fn () => $expectedReturn);
        $option->expects($this->once())
            ->method('execute')
            ->willReturn($expectedReturn);

        $input = $this->createMock(Input::class);
        $input->expects($this->once())
            ->method('read')
            ->willReturn('3');

        $output = $this->createMock(Output::class);
        $output->expects($this->once())
            ->method('write')
            ->with($expectedReturn);

        $menu = new Menu(
            new MenuOption('1', 'first 1', fn () => 'Hello world_1'),
            new MenuOption('2', 'first 2', fn () => 'Hello world_2'),
            $option,
        );
        $runner = new MenuRunner(
            menu: $menu, 
            formatter: $this->createStub(MenuFormatter::class), 
            input: $input, 
            output: $output
        );

        $runner->selectOptionFromInput();
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
