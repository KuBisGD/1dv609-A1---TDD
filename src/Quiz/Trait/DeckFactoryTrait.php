<?php

declare(strict_types=1);

namespace App\Tdd\Quiz\Trait;

use App\Tdd\Quiz\QuestionDeck;
use App\Tdd\Quiz\QuizQuestion;

trait DeckFactoryTrait
{
    function createDeck(QuizQuestion ...$questions): QuestionDeck
    {
        return new QuestionDeck(...$questions);
    }
}
