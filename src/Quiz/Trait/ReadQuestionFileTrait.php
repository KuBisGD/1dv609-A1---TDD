<?php

declare(strict_types=1);

namespace App\Tdd\Quiz\Trait;

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
        return fopen($filePath, 'r');
    }
}