<?php

declare(strict_types=1);

namespace App\Tdd\Console;

use App\Tdd\Console\Interface\Input;
use App\Tdd\Console\Interface\MenuFormatter;
use App\Tdd\Console\Interface\Output;

final class MenuRunner
{
    public function __construct(
        private Menu $menu, 
        private MenuFormatter $formatter, 
        private Input $input, 
        private Output $output)
    {}

    public function renderMenu(): void
    {
        $formatted = $this->formatter->format($this->menu);
        $this->output->write($formatted);
    }

    public function selectOptionFromInput(): void
    {
        $input = $this->input->read();
        $option = $this->menu->getOption($input);
        $return = $option->execute();

        if (isset($return)) {
            $this->output->write($return);
        }
    }
}
