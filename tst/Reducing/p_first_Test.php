<?php

declare(strict_types=1);

namespace Tests\Reducing;

use ArrayIterator;
use OutOfBoundsException;
use Tests\UnitTestCase;

use function ImpartialPipes\p_first;
use function Tests\p_assert_equals;
use function Tests\p_assert_throws;
use function Tests\pipe;

/**
 * @internal
 */
final class p_first_Test extends UnitTestCase
{
    public function test_p_first_with_arrays(): void
    {
        pipe([])
        ->toLazy(p_first())
        ->to(p_assert_throws(OutOfBoundsException::class));

        pipe([])
        ->toLazy(p_first(static fn (int $x) => $x > 1))
        ->to(p_assert_throws(OutOfBoundsException::class));

        pipe([1,2,3])
        ->to(p_first())
        ->to(p_assert_equals(1));

        pipe([1,2,3])
        ->to(p_first(static fn (int $x) => $x > 1))
        ->to(p_assert_equals(2));

        pipe([1,2,3])
        ->toLazy(p_first(static fn (int $x) => $x > 3))
        ->to(p_assert_throws(OutOfBoundsException::class));

        pipe(['a' => 1, 'aa' => 2, 'aaa' => 3])
        ->to(p_first())
        ->to(p_assert_equals(1));

        pipe(['a' => 1, 'aa' => 2, 'aaa' => 3])
        ->to(p_first(static fn (int $x, string $k) => strlen($k) > 1))
        ->to(p_assert_equals(2));

        pipe(['a' => 1, 'aa' => 2, 'aaa' => 3])
        ->toLazy(p_first(static fn (int $x, string $k) => strlen($k) > 3))
        ->to((p_assert_throws(OutOfBoundsException::class)));
    }

    public function test_p_first_with_iterables(): void
    {
        pipe(new ArrayIterator([]))
        ->toLazy(p_first())
        ->to(p_assert_throws(OutOfBoundsException::class));

        pipe(new ArrayIterator([]))
        ->toLazy(p_first(static fn (int $x) => $x > 1))
        ->to(p_assert_throws(OutOfBoundsException::class));

        pipe(new ArrayIterator([1,2,3]))
        ->to(p_first())
        ->to(p_assert_equals(1));

        pipe(new ArrayIterator([1,2,3]))
        ->to(p_first(static fn (int $x) => $x > 1))
        ->to(p_assert_equals(2));

        pipe(new ArrayIterator([1,2,3]))
        ->toLazy(p_first(static fn (int $x) => $x > 3))
        ->to(p_assert_throws(OutOfBoundsException::class));

        pipe(new ArrayIterator(['a' => 1, 'aa' => 2, 'aaa' => 3]))
        ->to(p_first())
        ->to(p_assert_equals(1));

        pipe(new ArrayIterator(['a' => 1, 'aa' => 2, 'aaa' => 3]))
        ->to(p_first(static fn (int $x, string $k) => strlen($k) > 1))
        ->to(p_assert_equals(2));

        pipe(new ArrayIterator(['a' => 1, 'aa' => 2, 'aaa' => 3]))
        ->toLazy(p_first(static fn (int $x, string $k) => strlen($k) > 3))
        ->to((p_assert_throws(OutOfBoundsException::class)));
    }
}
