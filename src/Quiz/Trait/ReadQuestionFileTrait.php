<?php

declare(strict_types=1);

namespace App\Tdd\Quiz\Trait;

trait ReadQuestionFileTrait
{
    protected function getParsedContent(string $fileName): array
    {
        
    }

    protected function getFileStream(string $filePath): mixed
    {
        return fopen($filePath, 'r');
    }
}