<?php

declare(strict_types=1);

use App\Tdd\Quiz\QuestionDeck;
use App\Tdd\Quiz\QuizQuestion;
use PHPUnit\Framework\Attributes\AllowMockObjectsWithoutExpectations;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(QuestionDeck::class)]
#[AllowMockObjectsWithoutExpectations]
final class QuestionDeckTest extends TestCase
{
    public function testCanBeCreatedWithQuestions(): void
    {
        $deck = new QuestionDeck(
            $this->createQuestionWithNoConstructor(), 
            $this->createQuestionWithNoConstructor(), 
            $this->createQuestionWithNoConstructor()
        );

        $this->assertInstanceOf(QuestionDeck::class, $deck);
    }

    public function testCorrectlyImplementsIterator(): void
    {
        $questions = [
            $this->createQuestionWithNoConstructor(), 
            $this->createQuestionWithNoConstructor(), 
            $this->createQuestionWithNoConstructor()
        ];

        $deck = new QuestionDeck(...$questions);

        $this->assertInstanceOf(Iterator::class, $deck, message: 'Must implement ' . Iterator::class);
        $this->assertArraysHaveEqualValues($questions, iterator_to_array($deck));
    }

    public function testDeckIsCountable(): void
    {
        $deck = new QuestionDeck(
            $this->createQuestionWithNoConstructor(), 
            $this->createQuestionWithNoConstructor(), 
            $this->createQuestionWithNoConstructor()
        );

        $this->assertInstanceOf(Countable::class, $deck);
        $this->assertEquals(3, count($deck));
    }

    private function createQuestionWithNoConstructor(): QuizQuestion
    {
        return $this->getMockBuilder(QuizQuestion::class)
            ->disableOriginalConstructor()
            ->getMock();
    }
}