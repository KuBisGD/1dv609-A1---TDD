<?php

declare(strict_types=1);

namespace App\Tdd\Quiz\Trait;

use InvalidArgumentException;

trait ReadQuestionFileTrait
{
    protected function getQuestionsFromFile(string $filePath): array
    {
        $content = '';
        $stream = $this->getFileStream($filePath);
        while ($line = fgets($stream)) {
            $content .= $line;
        }
        return json_decode($content, associative: true);
    }

    protected function getFileStream(string $filePath): mixed
    {
        if (! is_file($filePath)) {
            throw new InvalidArgumentException($filePath . ' is not a valid file');
        }
        return fopen($filePath, 'r');
    }
}