<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class MenuOptionTest extends TestCase
{
    public function testQuestionHasDescription(): void
    {
        $description = 'test description';
        $question = new MenuQuestion($description);

        $this->assertEquals($description, $question->description);
    }
}
