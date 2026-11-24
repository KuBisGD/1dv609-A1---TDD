<?php

declare(strict_types=1);

namespace App\Tdd\Quiz\Trait;

use App\Tdd\Quiz\QuizQuestion;

trait QuestionFactoryTrait
{
    protected function createQuestion(array $questions): QuizQuestion
    {
        return new QuizQuestion($questions['question'], $questions['answers']);
    }
}