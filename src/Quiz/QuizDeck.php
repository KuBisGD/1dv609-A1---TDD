<?php

declare(strict_types=1);

namespace App\Tdd\Quiz;

use App\Tdd\Quiz\Trait\QuestionFactoryTrait;

final class QuizDeck
{
    use QuestionFactoryTrait;

    public function __construct(string $filePath)
    {
        
    } 
}