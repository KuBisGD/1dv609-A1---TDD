<?php

declare(strict_types=1);

use App\Tdd\Quiz\QuizDeck;
use App\Tdd\Quiz\Trait\QuestionFactoryTrait;
use PHPUnit\Framework\TestCase;

final class QuizDeckTest extends TestCase
{
    private string $tempfileName;

    public function __construct(string $name)
    {
        parent::__construct($name);

        $tempfileName = tempnam(sys_get_temp_dir(), 'qdt');
        if ($tempfileName === false) {
            throw new Exception('could not create tmpfile for tests');
        }

        $this->tempfileName = $tempfileName;

        $questions = json_encode([
            [
                'question' => 'What is 2+2?',
                'answers' => [
                    ['answer' => '1', 'isCorrect' => false],
                    ['answer' => '2', 'isCorrect' => false],
                    ['answer' => '3', 'isCorrect' => false],
                    ['answer' => '4', 'isCorrect' => true],
                ],
            ],
            [
                'question' => 'What is 3 + 3?',
                'answers' => [
                    ['answer' => '5', 'isCorrect' => false],
                    ['answer' => '6', 'isCorrect' => false],
                    ['answer' => '7', 'isCorrect' => false],
                    ['answer' => '8', 'isCorrect' => true],
                ],
            ]
        ], JSON_THROW_ON_ERROR);

        if (file_put_contents($this->tempfileName, $questions) === false) {
            unlink($this->tempfileName);
            throw new Exception('could not write tmpfile for tests');
        }
    }

    public function __destruct()
    {
        if (isset($this->tempfileName) && is_file($this->tempfileName)) {
            unlink($this->tempfileName);
        }
    }
  

    function testQuizDeckCanBeCreateWithFilePath(): void
    {
        $deck = new QuizDeck($this->tempfileName);
        $this->assertInstanceOf(QuizDeck::class, $deck);
    }

    function testDeckCanCreateQuestions(): void
    {
        $this->assertTrue(in_array(QuestionFactoryTrait::class, class_uses(QuizDeck::class)));
    }
}