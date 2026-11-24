<?php

declare(strict_types=1);

use App\Tdd\Quiz\QuizQuestion;
use App\Tdd\Quiz\Trait\QuestionFactoryTrait;
use PHPUnit\Framework\TestCase;

final class QuestionFactoryTraitTest extends TestCase
{
    function testFactoryCanCrateTest(): void
    {
        $factory = new class {
            use QuestionFactoryTrait;

            public function create(array $question): QuizQuestion
            {
                return $this->createQuestion($question);
            }
        };


        $question = $factory->create([
            'question' => 'What is 2+2?',
            'answers' => [
                ['answer' => '1', 'isCorrect' => false],
                ['answer' => '2', 'isCorrect' => false],
                ['answer' => '3', 'isCorrect' => false],
                ['answer' => '4', 'isCorrect' => true],
            ],
        ]);

        $this->assertInstanceOf(QuizQuestion::class, $question);
    }
}