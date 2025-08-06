<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
abstract class UnitTestCase extends TestCase
{
    /**
     * @template K
     * @template V
     * @param iterable<K,V> $expected
     * @param iterable<K,V> $actual
     */
    public static function assertIteratesLike(iterable $expected, iterable $actual): void
    {
        self::assertEquals(iterator_to_array($expected), iterator_to_array($actual));
    }

    /**
     * @template T
     * @param T $value
     * @return Expectation<T>
     */
    public static function expect(mixed $value): Expectation
    {
        return new Expectation($value);
    }
}

/** @template T */
class Expectation
{
    /** @param T $value */
    public function __construct(private readonly mixed $value)
    {
    }

    /**
     * @template T2
     * @param callable(T):T2 $callable
     * @return Expectation<T2>
     */
    public function pipe(callable $callable): self
    {
        return new self($callable($this->value));
    }

    /**
     * @param T $expected
     */
    public function toBe(mixed $expected): void
    {
        Assert::assertEquals($expected, $this->value);
    }

    /**
     * @param iterable<mixed> $expected
     */
    public function toIterateLike(iterable $expected): void
    {
        $expected = iterator_to_array($expected);
        /** @var iterable<mixed> $value */
        $value = $this->value;
        iterator_to_array($value);
        $actual = iterator_to_array($value); // again to see if it is rewindable
        Assert::assertEquals($expected, $actual);
    }
}
