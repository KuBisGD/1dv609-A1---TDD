<?php

declare(strict_types=1);

namespace App\Tdd\Quiz;

use InvalidArgumentException;

final readonly class QuizQuestion
{
    public string $question;

    /**
     * @param non-empty-string $question
     * @param array<int, array{answer: string, isCorrect: bool}> $answers
     */
    public function __construct(string $question, public array $answers) {
        $this->question = trim($question);
        if (strlen($this->question) < 1) {
            throw new InvalidArgumentException('strlen of trimmed question must be at least 1');
        } 

        $count = count($answers);
        if ($count < 1) throw new InvalidArgumentException(self::class . ' must have at least one answer');
        $hasCorrectAnswer = false;
        for ($i = 0; $i < $count; $i++) {
            if (! isset($answers[$i]['answer'])) {
                throw new InvalidArgumentException('missing answer-string on answer index ' . $i);
            }
            if (! isset($answers[$i]['isCorrect'])) {
                throw new InvalidArgumentException('missing correctness on answer index ' . $i);
            }
            if ($answers[$i]['isCorrect'] === true) {
                $hasCorrectAnswer = true;
            }
        }
        if (! $hasCorrectAnswer) {
            throw new InvalidArgumentException(self::class . ' must have at least one correct answer');
        }
    }

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
