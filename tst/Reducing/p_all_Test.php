<?php

declare(strict_types=1);

namespace Tests\Reducing;

use ArrayIterator;
use Tests\UnitTestCase;

use function ImpartialPipes\p_all;
use function ImpartialPipes\pipe;
use function Tests\p_assert_equals;

/**
 * @internal
 */
final class p_all_Test extends UnitTestCase
{
    public function test_p_all_with_arrays(): void
    {
        pipe([])
        ->to(p_all(static fn (int $x) => $x % 2 === 1))
        ->to(p_assert_equals(true));

        pipe([])
        ->to(p_all(static fn (int $x, string $k) => $k[0] === 'a'))
        ->to(p_assert_equals(true));

        pipe([1, 3, 5])
        ->to(p_all(static fn (int $x) => $x % 2 === 1))
        ->to(p_assert_equals(true));

        pipe([1, 2, 5])
        ->to(p_all(static fn (int $x) => $x % 2 === 1))
        ->to(p_assert_equals(false));

        pipe(['a' => 1, 'aa' => 2, 'aaa' => 3])
        ->to(p_all(static fn (int $x, string $k) => $k[0] === 'a'))
        ->to(p_assert_equals(true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3])
        ->to(p_all(static fn (int $x, string $k) => $k[0] === 'a'))
        ->to(p_assert_equals(false));
    }

    public function test_p_all_with_iterators(): void
    {
        pipe(new ArrayIterator([]))
        ->to(p_all(static fn (int $x) => $x % 2 === 1))
        ->to(p_assert_equals(true));

        pipe(new ArrayIterator([]))
        ->to(p_all(static fn (int $x, string $k) => $k[0] === 'a'))
        ->to(p_assert_equals(true));

        pipe(new ArrayIterator([1, 3, 5]))
        ->to(p_all(static fn (int $x) => $x % 2 === 1))
        ->to(p_assert_equals(true));

        pipe(new ArrayIterator([1, 2, 5]))
        ->to(p_all(static fn (int $x) => $x % 2 === 1))
        ->to(p_assert_equals(false));

        pipe(new ArrayIterator(['a' => 1, 'aa' => 2, 'aaa' => 3]))
        ->to(p_all(static fn (int $x, string $k) => $k[0] === 'a'))
        ->to(p_assert_equals(true));

        pipe(new ArrayIterator(['a' => 1, 'b' => 2, 'c' => 3]))
        ->to(p_all(static fn (int $x, string $k) => $k[0] === 'a'))
        ->to(p_assert_equals(false));
    }
}
