<?php

declare(strict_types=1);

namespace App\Tdd\Quiz;

use App\Tdd\Quiz\Trait\DeckFactoryTrait;
use App\Tdd\Quiz\Trait\QuestionFactoryTrait;
use App\Tdd\Quiz\Trait\ReadQuestionFileTrait;

final class Quiz
{
    use ReadQuestionFileTrait, QuestionFactoryTrait, DeckFactoryTrait;

    private QuestionDeck $questions;

    public function __construct(string $questionsFilePath)
    {
        $questionsData = $this->getQuestionsFromFile($questionsFilePath);

        $questions = [];

        foreach ($questionsData as $question) {
            $questions[] = $this->createQuestion($question);
        }

        $this->questions = $this->createDeck(...$questions);
    }

    /**
     * @return array<QuizQuestion>
     */
    public function getQuestions(): array
    {
        $questions = [];

        foreach ($this->questions as $question) {
            $questions[] = $question;
        }

        return $questions;
    }
}