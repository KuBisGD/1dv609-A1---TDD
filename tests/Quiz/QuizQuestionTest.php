<?php

declare(strict_types=1);

use App\Tdd\Quiz\QuizQuestion;
use PHPUnit\Framework\TestCase;

final class QuizQuestionTest extends TestCase
{
    public function testQuestionIsCreatedWithQuestionAndAnswers(): void
    {
        $question = new QuizQuestion(question: 'What is 2+2?',
            answers: [
                ['answer' => '1', 'isCorrect' => false],
                ['answer' => '2', 'isCorrect' => false],
                ['answer' => '3', 'isCorrect' => false],
                ['answer' => '4', 'isCorrect' => true],
            ]
        );

        $this->assertInstanceOf(QuizQuestion::class, $question);
    }

    public function testGetQuestionAsString(): void
    {
        $questionString = 'What is 2+2?';
        $question = new QuizQuestion(question: $questionString,
            answers: [
                ['answer' => '1', 'isCorrect' => false],
                ['answer' => '2', 'isCorrect' => false],
                ['answer' => '3', 'isCorrect' => false],
                ['answer' => '4', 'isCorrect' => true],
            ]
        );

        $this->assertEquals($questionString, $question->question);
    }

    public function testSubmittingAnswerReturnsValidityOfSubmission(): void
    {
        $question = new QuizQuestion(question: 'What is 2+2?',
            answers: [
                ['answer' => '1', 'isCorrect' => false],
                ['answer' => '2', 'isCorrect' => false],
                ['answer' => '3', 'isCorrect' => false],
                ['answer' => '4', 'isCorrect' => true],
            ]
        );

        $false = $question->submitAnswer('3');
        $true = $question->submitAnswer('4');

        $this->assertFalse($false);
        $this->assertTrue($true);
    }
}
