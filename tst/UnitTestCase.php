<?php

declare(strict_types=1);

namespace Tests;

/**
 * @internal
 */
abstract class UnitTestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @template K
     * @template V
     * @param iterable<K,V> $expected
     * @param iterable<K,V> $actual
     */
    public static function assertIterEquals(iterable $expected, iterable $actual): void
    {
        self::assertEquals(iterator_to_array($expected), iterator_to_array($actual));
    }
}
