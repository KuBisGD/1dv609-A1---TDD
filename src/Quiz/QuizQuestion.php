<?php

declare(strict_types=1);

namespace App\Tdd\Quiz;

use InvalidArgumentException;

readonly class QuizQuestion
{
    /**
     * @param string $question
     * @param array<int, array{answer: string, isCorrect: bool}> $answers
     */
    public function __construct(public string $question, public array $answers) {
        $count = count($answers);
        if ($count < 1) throw new InvalidArgumentException(self::class . ' must have at least one answer');


        for ($i = 0; $i < $count; $i++) {
            if (! isset($answers[$i]['answer'])) {
                throw new InvalidArgumentException('missing answer-string on answer index ' . $i);
            }
            if (! isset($answers[$i]['isCorrect'])) {
                throw new InvalidArgumentException('missing correctness on answer index ' . $i);
            }
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
