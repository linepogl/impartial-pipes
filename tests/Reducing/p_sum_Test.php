<?php

declare(strict_types=1);

namespace ImpartialPipes\Tests\Reducing;

use ImpartialPipes\Tests\SimpleIterator;
use ImpartialPipes\Tests\UniterableArrayIterator;
use PHPUnit\Framework\TestCase;
use PHPUnitMetaConstraints\Util\PHPUnitMetaConstraintsTrait;

use function ImpartialPipes\p_sum;

/**
 * @internal
 */
final class p_sum_Test extends TestCase
{
    use PHPUnitMetaConstraintsTrait;

    public function test_p_sum_with_arrays(): void
    {
        []
        |> p_sum()
        |> self::is(0);

        // @phpstan-ignore deadCode.unreachable (wtf phpstan!)
        [1,2,3]
        |> p_sum()
        |> self::is(6);

        [1,-12.8,4.4]
        |> p_sum()
        |> self::is(-7.4);
    }
    public function test_p_sum_with_array_iterators(): void
    {
        new UniterableArrayIterator([])
        |> p_sum()
        |> self::is(0);

        // @phpstan-ignore deadCode.unreachable (wtf phpstan!)
        new UniterableArrayIterator([1,2,3])
        |> p_sum()
        |> self::is(6);

        new UniterableArrayIterator([1,-12.8,4.4])
        |> p_sum()
        |> self::is(-7.4);
    }
    public function test_p_sum_with_simple_iterators(): void
    {
        new SimpleIterator([])
        |> p_sum()
        |> self::is(0);

        // @phpstan-ignore deadCode.unreachable (wtf phpstan!)
        new SimpleIterator([1,2,3])
        |> p_sum()
        |> self::is(6);

        new SimpleIterator([1,-12.8,4.4])
        |> p_sum()
        |> self::is(-7.4);
    }
}
