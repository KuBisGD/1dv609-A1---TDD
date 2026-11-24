<?php

declare(strict_types=1);

namespace App\Tdd\Quiz;

use App\Tdd\Quiz\Trait\QuestionFactoryTrait;
use App\Tdd\Quiz\Trait\ReadQuestionFileTrait;

final class Quiz
{
    use ReadQuestionFileTrait, QuestionFactoryTrait;

    private array $questions;

    public function __construct(string $questionsFilePath)
    {
        $questionsData = $this->getQuestionsFromFile($questionsFilePath);

        $this->questions = [];

        foreach ($questionsData as $question) {
            $this->questions[] = $this->createQuestion($question);
        }
    }

    /**
     * @return array<QuizQuestion>
     */
    public function getQuestions(): array
    {
        return $this->questions;
    }
}