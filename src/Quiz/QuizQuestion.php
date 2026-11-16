<?php

declare(strict_types=1);

namespace App\Tdd\Quiz;

readonly class QuizQuestion
{
    /**
     * @param string $question
     * @param array<int, array{answer: string, isCorrect: bool}> $answers
     */
    public function __construct(public string $question, public array $answers) {}

    public function submitAnswer(string $answer): bool
    {
        foreach ($this->answers as $answerOption) {
            if ($answerOption['isCorrect']) {
                return $answerOption['answer'] === $answer;
            }
        }

        return false;
    }
}
