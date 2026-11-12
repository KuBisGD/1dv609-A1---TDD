<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Tdd\Console\MenuOption;

final class MenuOptionTest extends TestCase
{
    public function testQuestionHasDescription(): void
    {
        $description = 'test description';
        $question = new MenuOption($description);

        $this->assertEquals($description, $question->description);
    }
}
