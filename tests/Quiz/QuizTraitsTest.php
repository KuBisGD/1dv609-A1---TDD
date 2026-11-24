<?php

declare(strict_types=1);

use App\Tdd\Quiz\QuizQuestion;
use App\Tdd\Quiz\Trait\QuestionFactoryTrait;
use App\Tdd\Quiz\Trait\ReadQuestionFileTrait;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

final class QuizTraitsTest extends TestCase
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

    public function __destruct()
    {
        if (isset($this->tempfileName) && is_file($this->tempfileName)) {
            unlink($this->tempfileName);
        }
    }

    function testFactoryCanCrateTest(): void
    {
        $factory = new class {
            use QuestionFactoryTrait;

            public function create(array $question): QuizQuestion
            {
                return $this->createQuestion($question);
            }
        };


        $question = $factory->create([
            'question' => 'What is 2+2?',
            'answers' => [
                ['answer' => '1', 'isCorrect' => false],
                ['answer' => '2', 'isCorrect' => false],
                ['answer' => '3', 'isCorrect' => false],
                ['answer' => '4', 'isCorrect' => true],
            ],
        ]);

        $this->assertInstanceOf(QuizQuestion::class, $question);
    }

    public function testReadCanOpenQuestionFile(): void
    {
        $reader = new class($this->tempfileName) {
            use ReadQuestionFileTrait;

            public function __construct(private string $path) {}
    
            public function read(): mixed
            {
                return $this->getFileStream($this->path);  
            }
        };

        $this->assertIsResource($reader->read());
    }

    public function testParsingQuestionFileIsCorrect(): void
    {
        $reader = new class($this->tempfileName) {
            use ReadQuestionFileTrait;

            public function __construct(private string $path) {}
    
            public function parse(): mixed
            {
                return $this->getQuestionsFromFile($this->path);  
            }
        };

        $this->assertArraysHaveIdenticalValues($this->data, $reader->parse());
    }
}