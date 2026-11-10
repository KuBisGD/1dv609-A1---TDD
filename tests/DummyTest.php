<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

/**
 * Dummy test to confirm Frame work is loaded.
 */
final class DummyTest extends TestCase
{
    public function testFrameWorkIsLoaded(): void
    {
        $this->assertTrue(condition: (1 === 1), message: '1 is eq to 1');
    }
}
