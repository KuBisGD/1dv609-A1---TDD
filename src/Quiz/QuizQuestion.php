<?php

declare(strict_types=1);

namespace App\Tdd\Quiz;

readonly class QuizQuestion
{
    public function __construct(public string $question, array $answers)
    {
        
    }
}
