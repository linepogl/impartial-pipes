<?php

declare(strict_types=1);

namespace Tests\Reducing;

use PHPUnit\Framework\TestCase;
use Tests\SimpleIterator;
use Tests\UniterableArrayIterator;

use function ImpartialPipes\p_sum;
use function ImpartialPipes\pipe;
use function Tests\p_assert_equals;

/**
 * @internal
 */
final class p_sum_Test extends TestCase
{
    public function test_p_sum_with_arrays(): void
    {
        pipe([])
        ->to(p_sum())
        ->to(p_assert_equals(0));

        pipe([1,2,3])
        ->to(p_sum())
        ->to(p_assert_equals(6));

        pipe([1,-12.8,4.4])
        ->to(p_sum())
        ->to(p_assert_equals(-7.4));
    }
    public function test_p_sum_with_array_iterators(): void
    {
        pipe(new UniterableArrayIterator([]))
        ->to(p_sum())
        ->to(p_assert_equals(0));

        pipe(new UniterableArrayIterator([1,2,3]))
        ->to(p_sum())
        ->to(p_assert_equals(6));

        pipe(new UniterableArrayIterator([1,-12.8,4.4]))
        ->to(p_sum())
        ->to(p_assert_equals(-7.4));
    }
    public function test_p_sum_with_simple_iterators(): void
    {
        pipe(new SimpleIterator([]))
        ->to(p_sum())
        ->to(p_assert_equals(0));

        pipe(new SimpleIterator([1,2,3]))
        ->to(p_sum())
        ->to(p_assert_equals(6));

        pipe(new SimpleIterator([1,-12.8,4.4]))
        ->to(p_sum())
        ->to(p_assert_equals(-7.4));
    }
}
