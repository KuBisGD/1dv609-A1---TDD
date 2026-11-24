<?php

declare(strict_types=1);

use App\Tdd\Quiz\Quiz;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Quiz::class)]
final class QuizTest extends TestCase
{
    private string $tempfileName;
    private array $data;

    public function __construct(string $name)
    {
        parent::__construct($name);

        $tempfileName = tempnam(sys_get_temp_dir(), 'qdt');
        if ($tempfileName === false) {
            throw new Exception('could not create tmpfile for tests');
        }

        $this->tempfileName = $tempfileName;

        $this->data = [
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
        ];

        $questions = json_encode($this->data, JSON_THROW_ON_ERROR);

        if (file_put_contents($this->tempfileName, $questions) === false) {
            unlink($this->tempfileName);
            throw new Exception('could not write tmpfile for tests');
        }
    }

    public function testQuizCanBeCreatedWithFilePathToQuestions(): void
    {
        $quiz = new Quiz($this->tempfileName);
        $this->assertInstanceOf(Quiz::class, $quiz);
    }
}