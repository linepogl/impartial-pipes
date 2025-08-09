<?php

declare(strict_types=1);

namespace Tests\Reducing;

use ArrayIterator;
use OutOfBoundsException;
use Tests\UnitTestCase;

use function ImpartialPipes\p_last_key;
use function ImpartialPipes\pipe;
use function Tests\p_assert_equals;
use function Tests\p_assert_throws;

/**
 * @internal
 */
final class p_last_key_Test extends UnitTestCase
{
    public function test_p_last_key_with_arrays(): void
    {
        pipe(static fn () => (
            pipe([])
            ->to(p_last_key())
        ))->to(p_assert_throws(OutOfBoundsException::class));

        pipe(static fn () => (
            pipe([])
            ->to(p_last_key(static fn (int $x) => $x < 3))
        ))->to(p_assert_throws(OutOfBoundsException::class));

        pipe([1,2,3])
        ->to(p_last_key())
        ->to(p_assert_equals(2));

        pipe([1,2,3])
        ->to(p_last_key(static fn (int $x) => $x < 3))
        ->to(p_assert_equals(1));

        pipe(static fn () => (
            pipe([1,2,3])
            ->to(p_last_key(static fn (int $x) => $x > 3))
        ))->to(p_assert_throws(OutOfBoundsException::class));

        pipe(['a' => 1, 'aa' => 2, 'aaa' => 3])
        ->to(p_last_key())
        ->to(p_assert_equals('aaa'));

        pipe(['a' => 1, 'aa' => 2, 'aaa' => 3])
        ->to(p_last_key(static fn (int $x, string $k) => strlen($k) < 3))
        ->to(p_assert_equals('aa'));

        pipe(static fn () => (
            pipe(['a' => 1, 'aa' => 2, 'aaa' => 3])
            ->to(p_last_key(static fn (int $x, string $k) => strlen($k) > 3))
        ))->to(p_assert_throws(OutOfBoundsException::class));
    }

    public function test_p_last_key_with_iterables(): void
    {
        pipe(static fn () => (
            pipe(new ArrayIterator([]))
            ->to(p_last_key())
        ))->to(p_assert_throws(OutOfBoundsException::class));

        pipe(static fn () => (
            pipe(new ArrayIterator([]))
            ->to(p_last_key(static fn (int $x) => $x < 3))
        ))->to(p_assert_throws(OutOfBoundsException::class));

        pipe(new ArrayIterator([1,2,3]))
        ->to(p_last_key())
        ->to(p_assert_equals(2));

        pipe(new ArrayIterator([1,2,3]))
        ->to(p_last_key(static fn (int $x) => $x < 3))
        ->to(p_assert_equals(1));

        pipe(static fn () => (
            pipe(new ArrayIterator([1,2,3]))
            ->to(p_last_key(static fn (int $x) => $x > 3))
        ))->to(p_assert_throws(OutOfBoundsException::class));

        pipe(new ArrayIterator(['a' => 1, 'aa' => 2, 'aaa' => 3]))
        ->to(p_last_key())
        ->to(p_assert_equals('aaa'));

        pipe(new ArrayIterator(['a' => 1, 'aa' => 2, 'aaa' => 3]))
        ->to(p_last_key(static fn (int $x, string $k) => strlen($k) < 3))
        ->to(p_assert_equals('aa'));

        pipe(static fn () => (
            pipe(new ArrayIterator(['a' => 1, 'aa' => 2, 'aaa' => 3]))
            ->to(p_last_key(static fn (int $x, string $k) => strlen($k) > 3))
        ))->to(p_assert_throws(OutOfBoundsException::class));
    }
}
