<?php

declare(strict_types=1);

namespace Tests\Reducing;

use ArrayIterator;
use Tests\UnitTestCase;

use function ImpartialPipes\p_first_key_or;
use function Tests\p_assert_equals;
use function Tests\pipe;

/**
 * @internal
 */
final class p_first_key_or_Test extends UnitTestCase
{
    public function test_p_first_key_or_with_arrays(): void
    {
        pipe([])
        ->to(p_first_key_or(null))
        ->to(p_assert_equals(null));

        pipe([])
        ->to(p_first_key_or(null, static fn (int $x) => $x > 1))
        ->to(p_assert_equals(null));

        pipe([1,2,3])
        ->to(p_first_key_or(null))
        ->to(p_assert_equals(0));

        pipe([1,2,3])
        ->to(p_first_key_or(null, static fn (int $x) => $x > 1))
        ->to(p_assert_equals(1));

        pipe([1,2,3])
        ->to(p_first_key_or(null, static fn (int $x) => $x > 3))
        ->to(p_assert_equals(null));

        pipe(['a' => 1, 'aa' => 2, 'aaa' => 3])
        ->to(p_first_key_or(null))
        ->to(p_assert_equals('a'));

        pipe(['a' => 1, 'aa' => 2, 'aaa' => 3])
        ->to(p_first_key_or(null, static fn (int $x, string $k) => strlen($k) > 1))
        ->to(p_assert_equals('aa'));

        pipe(['a' => 1, 'aa' => 2, 'aaa' => 3])
        ->to(p_first_key_or(null, static fn (int $x, string $k) => strlen($k) > 3))
        ->to(p_assert_equals(null));
    }

    public function test_p_first_key_or_with_iterables(): void
    {
        pipe(new ArrayIterator([]))
        ->to(p_first_key_or(null))
        ->to(p_assert_equals(null));

        pipe(new ArrayIterator([]))
        ->to(p_first_key_or(null, static fn (int $x) => $x > 1))
        ->to(p_assert_equals(null));

        pipe(new ArrayIterator([1,2,3]))
        ->to(p_first_key_or(null))
        ->to(p_assert_equals(0));

        pipe(new ArrayIterator([1,2,3]))
        ->to(p_first_key_or(null, static fn (int $x) => $x > 1))
        ->to(p_assert_equals(1));

        pipe(new ArrayIterator([1,2,3]))
        ->to(p_first_key_or(null, static fn (int $x) => $x > 3))
        ->to(p_assert_equals(null));

        pipe(new ArrayIterator(['a' => 1, 'aa' => 2, 'aaa' => 3]))
        ->to(p_first_key_or(null))
        ->to(p_assert_equals('a'));

        pipe(new ArrayIterator(['a' => 1, 'aa' => 2, 'aaa' => 3]))
        ->to(p_first_key_or(null, static fn (int $x, string $k) => strlen($k) > 1))
        ->to(p_assert_equals('aa'));

        pipe(new ArrayIterator(['a' => 1, 'aa' => 2, 'aaa' => 3]))
        ->to(p_first_key_or(null, static fn (int $x, string $k) => strlen($k) > 3))
        ->to(p_assert_equals(null));
    }
}
