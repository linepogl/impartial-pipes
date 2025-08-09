<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\Constraint\IsEqual;
use PHPUnit\Framework\Constraint\IsInstanceOf;
use PHPUnit\Framework\TestCase;
use Throwable;

/** @return callable<A>(A):A */
function p_assert_that(Constraint $constraint, string $message = ''): callable
{
    return static function (mixed $actual) use ($constraint, $message) {
        Assert::assertThat($actual, $constraint, $message);
        return $actual;
    };
}

/** @return callable<A>(A):A */
function p_assert_equals(mixed $expected, string $message = ''): callable
{
    return p_assert_that(new IsEqual($expected), $message);
}

/**
 * @template E of object
 * @param class-string<E> $expected
 * @return callable(mixed):E
 */
function p_assert_instance_of(string $expected, string $message = ''): callable
{
    return p_assert_that(new IsInstanceOf($expected), $message); // @phpstan-ignore return.type (narrowing A to E)
}


/**
 * @param iterable<mixed,mixed> $expected
 * @return callable<A of iterable>(A):A
 */
function p_assert_iterates_like(iterable $expected, string $message = ''): callable
{
    return static function (iterable $actual) use ($expected, $message) {
        $expectedArray = [];
        foreach ($expected as $key => $value) {
            $expectedArray[] = [$key, $value];
        }

        iterator_to_array($actual); // iterate once to see if it is rewindable
        $actualArray = [];
        foreach ($actual as $key => $value) {
            $actualArray[] = [$key, $value];
        }

        p_assert_equals($expectedArray, $message)($actualArray);
        return $actual;
    };
}

/**
 * @param class-string<Throwable>|Throwable $expected
 * @return callable(callable):callable
 */
function p_assert_throws(string|Throwable $expected, string $message = ''): callable
{
    return function (callable $callable) use ($expected, $message) {
        $class = is_string($expected) ? $expected : $expected::class;
        try {
            $callable();
            Assert::fail('' !== $message ? $message : "Expected $class to be thrown, but nothing was.");
        } catch (AssertionFailedError $ex) {
            throw $ex;
        } catch (Throwable $actual) {
            Assert::assertInstanceOf($class, $actual);
            if ($expected instanceof Throwable) {
                Assert::assertEquals($expected->getMessage(), $actual->getMessage());
                Assert::assertEquals($expected->getCode(), $actual->getCode());
            }
            return $callable;
        }
    };
}

/**
 * @internal
 */
abstract class UnitTestCase extends TestCase
{
}
