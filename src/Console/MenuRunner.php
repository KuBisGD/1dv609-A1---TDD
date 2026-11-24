<?php

declare(strict_types=1);

namespace App\Tdd\Console;

use App\Tdd\Console\Interface\InputInterface;
use App\Tdd\Console\Interface\MenuFormatterInterface;
use App\Tdd\Console\Interface\OutputInterface;

final class MenuRunner
{
    public function __construct(
        private Menu $menu, 
        private MenuFormatterInterface $formatter, 
        private InputInterface $input, 
        private OutputInterface $output)
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
