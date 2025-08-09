<?php

declare(strict_types=1);

namespace Tests\Reducing;

use ArrayIterator;
use OutOfBoundsException;
use PHPUnit\Framework\TestCase;

use function ImpartialPipes\p_first;
use function ImpartialPipes\pipe;
use function Tests\p_assert_equals;
use function Tests\p_assert_throws;

/**
 * @internal
 */
final class p_first_Test extends TestCase
{
    public function test_p_first_with_arrays(): void
    {
        p_assert_throws(OutOfBoundsException::class)(
            static fn () =>
            pipe([])
            ->to(p_first())
        );

        p_assert_throws(OutOfBoundsException::class)(
            static fn () =>
            pipe([])
            ->to(p_first(static fn (int $x) => $x > 1))
        );

        pipe([1,2,3])
        ->to(p_first())
        ->to(p_assert_equals(1));

        pipe([1,2,3])
        ->to(p_first(static fn (int $x) => $x > 1))
        ->to(p_assert_equals(2));

        p_assert_throws(OutOfBoundsException::class)(
            static fn () =>
            pipe([1,2,3])
            ->to(p_first(static fn (int $x) => $x > 3))
        );

        pipe(['a' => 1, 'aa' => 2, 'aaa' => 3])
        ->to(p_first())
        ->to(p_assert_equals(1));

        pipe(['a' => 1, 'aa' => 2, 'aaa' => 3])
        ->to(p_first(static fn (int $x, string $k) => strlen($k) > 1))
        ->to(p_assert_equals(2));

        p_assert_throws(OutOfBoundsException::class)(
            static fn () =>
            pipe(['a' => 1, 'aa' => 2, 'aaa' => 3])
            ->to(p_first(static fn (int $x, string $k) => strlen($k) > 3))
        );
    }

    public function test_p_first_with_iterables(): void
    {
        p_assert_throws(OutOfBoundsException::class)(
            static fn () =>
            pipe(new ArrayIterator([]))
            ->to(p_first())
        );

        p_assert_throws(OutOfBoundsException::class)(
            static fn () =>
            pipe(new ArrayIterator([]))
            ->to(p_first(static fn (int $x) => $x > 1))
        );

        pipe(new ArrayIterator([1,2,3]))
        ->to(p_first())
        ->to(p_assert_equals(1));

        pipe(new ArrayIterator([1,2,3]))
        ->to(p_first(static fn (int $x) => $x > 1))
        ->to(p_assert_equals(2));

        p_assert_throws(OutOfBoundsException::class)(
            static fn () =>
            pipe(new ArrayIterator([1,2,3]))
            ->to(p_first(static fn (int $x) => $x > 3))
        );

        pipe(new ArrayIterator(['a' => 1, 'aa' => 2, 'aaa' => 3]))
        ->to(p_first())
        ->to(p_assert_equals(1));

        pipe(new ArrayIterator(['a' => 1, 'aa' => 2, 'aaa' => 3]))
        ->to(p_first(static fn (int $x, string $k) => strlen($k) > 1))
        ->to(p_assert_equals(2));

        p_assert_throws(OutOfBoundsException::class)(
            static fn () =>
            pipe(new ArrayIterator(['a' => 1, 'aa' => 2, 'aaa' => 3]))
            ->to(p_first(static fn (int $x, string $k) => strlen($k) > 3))
        );
    }
}
