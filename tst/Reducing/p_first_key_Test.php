<?php

declare(strict_types=1);

namespace Tests\Reducing;

use ArrayIterator;
use OutOfBoundsException;
use PHPUnit\Framework\TestCase;

use function ImpartialPipes\p_first_key;
use function ImpartialPipes\pipe;
use function Tests\p_assert_equals;
use function Tests\p_assert_throws;

/**
 * @internal
 */
final class p_first_key_Test extends TestCase
{
    public function test_p_first_key_with_arrays(): void
    {
        p_assert_throws(OutOfBoundsException::class)(
            static fn () =>
            pipe([])
            ->to(p_first_key())
        );

        p_assert_throws(OutOfBoundsException::class)(
            static fn () =>
            pipe([])
            ->to(p_first_key(static fn (int $x) => $x > 1))
        );

        pipe([1,2,3])
        ->to(p_first_key())
        ->to(p_assert_equals(0));

        pipe([1,2,3])
        ->to(p_first_key(static fn (int $x) => $x > 1))
        ->to(p_assert_equals(1));

        p_assert_throws(OutOfBoundsException::class)(
            static fn () =>
            pipe([1,2,3])
            ->to(p_first_key(static fn (int $x) => $x > 3))
        );

        pipe(['a' => 1, 'aa' => 2, 'aaa' => 3])
        ->to(p_first_key())
        ->to(p_assert_equals('a'));

        pipe(['a' => 1, 'aa' => 2, 'aaa' => 3])
        ->to(p_first_key(static fn (int $x, string $k) => strlen($k) > 1))
        ->to(p_assert_equals('aa'));

        p_assert_throws(OutOfBoundsException::class)(
            static fn () =>
            pipe(['a' => 1, 'aa' => 2, 'aaa' => 3])
            ->to(p_first_key(static fn (int $x, string $k) => strlen($k) > 3))
        );
    }

    public function test_p_first_key_with_iterables(): void
    {
        p_assert_throws(OutOfBoundsException::class)(
            static fn () =>
            pipe(new ArrayIterator([]))
            ->to(p_first_key())
        );

        p_assert_throws(OutOfBoundsException::class)(
            static fn () =>
            pipe(new ArrayIterator([]))
            ->to(p_first_key(static fn (int $x) => $x > 1))
        );

        pipe(new ArrayIterator([1,2,3]))
        ->to(p_first_key())
        ->to(p_assert_equals(0));

        pipe(new ArrayIterator([1,2,3]))
        ->to(p_first_key(static fn (int $x) => $x > 1))
        ->to(p_assert_equals(1));

        p_assert_throws(OutOfBoundsException::class)(
            static fn () =>
            pipe(new ArrayIterator([1,2,3]))
            ->to(p_first_key(static fn (int $x) => $x > 3))
        );

        pipe(new ArrayIterator(['a' => 1, 'aa' => 2, 'aaa' => 3]))
        ->to(p_first_key())
        ->to(p_assert_equals('a'));

        pipe(new ArrayIterator(['a' => 1, 'aa' => 2, 'aaa' => 3]))
        ->to(p_first_key(static fn (int $x, string $k) => strlen($k) > 1))
        ->to(p_assert_equals('aa'));

        p_assert_throws(OutOfBoundsException::class)(
            static fn () =>
            pipe(new ArrayIterator(['a' => 1, 'aa' => 2, 'aaa' => 3]))
            ->to(p_first_key(static fn (int $x, string $k) => strlen($k) > 3))
        );
    }
}
