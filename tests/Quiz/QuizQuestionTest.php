<?php

declare(strict_types=1);

use App\Tdd\Quiz\QuizQuestion;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class QuizQuestionTest extends TestCase
{
    public function testQuestionIsCreatedWithQuestionAndAnswers(): void
    {
        $template = $this->getQuestionTemplate();
        $question = new QuizQuestion($template['question'], $template['answers']);

        $this->assertInstanceOf(QuizQuestion::class, $question);
    }

    public function testGetQuestionAsString(): void
    {
        $template = $this->getQuestionTemplate();
        $question = new QuizQuestion($template['question'], $template['answers']);

        $this->assertEquals($template['question'], $question->question);
    }

    public function testQuestionThrowsOnEmptyQuestionString(): void
    {
        $template = $this->getQuestionTemplate();
        $this->expectException(InvalidArgumentException::class);
        new QuizQuestion('', $template['answers']);
        new QuizQuestion(' ', $template['answers']);
        new QuizQuestion('    ', $template['answers']);
    }

    public function testSubmittingAnswerReturnsValidityOfSubmission(): void
    {
        $template = $this->getQuestionTemplate();
        $question = new QuizQuestion($template['question'], $template['answers']);

        $false = $question->submitAnswer($template['wrong']);
        $true = $question->submitAnswer($template['correct']);

        $this->assertFalse($false);
        $this->assertTrue($true);
    }

    #[DataProvider('invalidAnswersProvider')]
    public function testInvalidQuestionFormatThrows($answers): void
    {
        $this->expectException(InvalidArgumentException::class);
        new QuizQuestion('What is 2 + 2?', $answers);
    }

    
    public static function invalidAnswersProvider(): array
    {
        return [
            'empty answer array' => [[]],
            'incorrect array associations (answer)' => [['a' => 'a', 'isCorrect' => true]],
            'incorrect array associations (isCorrect)' => [['answer' => 'a', 'i' => true]],
            'no correct answers' => [['answer' => '1', 'isCorrect' => false]],
        ];
    }

    private function getQuestionTemplate(): array
    {
        return [
            'question' => 'What is 2+2?',
            'answers' => [
                ['answer' => '1', 'isCorrect' => false],
                ['answer' => '2', 'isCorrect' => false],
                ['answer' => '3', 'isCorrect' => false],
                ['answer' => '4', 'isCorrect' => true],
            ],
            'correct' => '4',
            'wrong' => '3',
        ];
    }
}
