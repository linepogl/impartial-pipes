<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
abstract class UnitTestCase extends TestCase
{
    /**
     * @param iterable<mixed> $expected
     * @param iterable<mixed> $actual
     */
    public static function assertIterEquals(iterable $expected, iterable $actual): void
    {
        static::assertEquals(iterator_to_array($expected), iterator_to_array($actual));
    }
}
