<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\TestCase;
use Throwable;

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
     * @template T2
     * @param callable(T):T2 $callable
     * @return Expectation<callable():T2>
     */
    public function lazyPipe(callable $callable): self
    {
        return new self(fn () => $callable($this->value)); // @phpstan-ignore return.type (Closure and callable are the essentially same)
    }

    public function toBe(mixed $expected): void
    {
        Assert::assertEquals($expected, $this->value);
    }

    /**
     * @param class-string $expected
     */
    public function toBeInstanceOf(string $expected): void
    {
        Assert::assertInstanceOf($expected, $this->value);
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

    /**
     * @param class-string<Throwable>|Throwable $expected
     */
    public function toThrow(string|Throwable $expected): void
    {
        /** @var callable $value */
        $value = $this->value;
        $class = is_string($expected) ? $expected : $expected::class;
        try {
            $value();
            Assert::fail("Expected $class to be thrown, but nothing was.");
        } catch (AssertionFailedError $ex) {
            throw $ex;
        } catch (Throwable $actual) {
            Assert::assertInstanceOf($class, $actual);
            if ($expected instanceof Throwable) {
                Assert::assertEquals($expected->getMessage(), $actual->getMessage());
                Assert::assertEquals($expected->getCode(), $actual->getCode());
            }
        }
    }
}
