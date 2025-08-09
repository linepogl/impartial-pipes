<?php

declare(strict_types=1);

namespace Tests\Reducing;

use ArrayIterator;
use Tests\SimpleIterator;
use Tests\UniterableArrayIterator;
use Tests\UnitTestCase;

use function ImpartialPipes\p_any;
use function ImpartialPipes\pipe;
use function Tests\p_assert_equals;

/**
 * @internal
 */
final class p_any_Test extends UnitTestCase
{
    public function test_p_any_with_arrays(): void
    {
        pipe([])
        ->to(p_any(static fn (int $x) => $x % 2 === 1))
        ->to(p_assert_equals(false));

        pipe([])
        ->to(p_any(static fn (int $x, string $k) => $k[0] === 'a'))
        ->to(p_assert_equals(false));

        pipe([2, 3, 4])
        ->to(p_any(static fn (int $x) => $x % 2 === 1))
        ->to(p_assert_equals(true));

        pipe([2, 4, 6])
        ->to(p_any(static fn (int $x) => $x % 2 === 1))
        ->to(p_assert_equals(false));

        pipe(['aa' => 1, 'bb' => 2, 'cc' => 3])
        ->to(p_any(static fn (int $x, string $k) => $k[0] === 'b'))
        ->to(p_assert_equals(true));

        pipe(['aa' => 1, 'bb' => 2, 'cc' => 3])
        ->to(p_any(static fn (int $x, string $k) => $k[0] === 'd'))
        ->to(p_assert_equals(false));
    }

    public function test_p_any_with_iterators(): void
    {
        pipe(new ArrayIterator([]))
        ->to(p_any(static fn (int $x) => $x % 2 === 1))
        ->to(p_assert_equals(false));

        pipe(new ArrayIterator([]))
        ->to(p_any(static fn (int $x, string $k) => $k[0] === 'a'))
        ->to(p_assert_equals(false));

        pipe(new ArrayIterator([2, 3, 4]))
        ->to(p_any(static fn (int $x) => $x % 2 === 1))
        ->to(p_assert_equals(true));

        pipe(new ArrayIterator([2, 4, 6]))
        ->to(p_any(static fn (int $x) => $x % 2 === 1))
        ->to(p_assert_equals(false));

        pipe(new ArrayIterator(['aa' => 1, 'bb' => 2, 'cc' => 3]))
        ->to(p_any(static fn (int $x, string $k) => $k[0] === 'b'))
        ->to(p_assert_equals(true));

        pipe(new ArrayIterator(['aa' => 1, 'bb' => 2, 'cc' => 3]))
        ->to(p_any(static fn (int $x, string $k) => $k[0] === 'd'))
        ->to(p_assert_equals(false));
    }

    public function test_p_any_without_a_predicate(): void
    {
        pipe([])
        ->to(p_any())
        ->to(p_assert_equals(false));

        pipe([1, 2])
        ->to(p_any())
        ->to(p_assert_equals(true));

        pipe(new UniterableArrayIterator([]))
        ->to(p_any())
        ->to(p_assert_equals(false));

        pipe(new UniterableArrayIterator([1, 2]))
        ->to(p_any())
        ->to(p_assert_equals(true));

        pipe(new SimpleIterator([]))
        ->to(p_any())
        ->to(p_assert_equals(false));

        pipe(new SimpleIterator([1, 2]))
        ->to(p_any())
        ->to(p_assert_equals(true));
    }
}
