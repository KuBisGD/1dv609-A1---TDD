<?php

declare(strict_types=1);

use App\Tdd\Quiz\QuizDeck;
use PHPUnit\Framework\TestCase;

final class QuizDeckTest extends TestCase
{
    private const string QUESTION_FILE_PATH = __DIR__.'/questions.json';

    function testQuizDeckCanBeCreateWithFilePath(): void
    {
        $deck = new QuizDeck(self::QUESTION_FILE_PATH);
        $this->assertInstanceOf(QuizDeck::class, $deck);
    }
}