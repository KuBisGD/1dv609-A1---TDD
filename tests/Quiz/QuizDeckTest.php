<?php

declare(strict_types=1);

use App\Tdd\Quiz\QuizDeck;
use App\Tdd\Quiz\Trait\QuestionFactoryTrait;
use PHPUnit\Framework\TestCase;

final class QuizDeckTest extends TestCase
{
    private const string QUESTION_FILE_PATH = __DIR__.'/questions.json';

    function testQuizDeckCanBeCreateWithFilePath(): void
    {
        $deck = new QuizDeck(self::QUESTION_FILE_PATH);
        $this->assertInstanceOf(QuizDeck::class, $deck);
    }

    function testDeckCanCreateQuestions(): void
    {
        $this->assertTrue(in_array(QuestionFactoryTrait::class, class_uses(QuizDeck::class)));
    }
}