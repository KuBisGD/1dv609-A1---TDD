<?php

declare(strict_types=1);

namespace App\Tdd\Quiz;

use Countable;
use Iterator;
use Override;

final class QuestionDeck implements Iterator, Countable
{
    /**
     * @var array<int, QuizQuestion>
     */
    private array $questions;

    private int $internalIterator = 0;

    public function __construct(QuizQuestion ...$questions) {
        $this->questions = $questions;
    }

    #[Override]
    public function next(): void
    {
        $this->internalIterator++;
    }

    #[Override]
    public function rewind(): void
    {
        $this->internalIterator = 0;
    }

    #[Override]
    public function valid(): bool
    {
        return isset($this->questions[$this->internalIterator]);
    }

    #[Override]
    public function current(): QuizQuestion
    {
        return $this->questions[$this->internalIterator];
    }

    #[Override]
    public function key(): int
    {
        return $this->internalIterator;
    }

    #[Override]
    public function count(): int
    {
        return count($this->questions);
    }
}
