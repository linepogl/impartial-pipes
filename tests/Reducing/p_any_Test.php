<?php

declare(strict_types=1);

namespace ImpartialPipes\Tests\Reducing;

use ArrayIterator;
use ImpartialPipes\Tests\SimpleIterator;
use ImpartialPipes\Tests\UniterableArrayIterator;
use PHPUnit\Framework\TestCase;
use PHPUnitMetaConstraints\Util\PHPUnitMetaConstraintsTrait;

use function ImpartialPipes\p_any;

/**
 * @internal
 */
final class p_any_Test extends TestCase
{
    use PHPUnitMetaConstraintsTrait;

    public function test_p_any_with_arrays(): void
    {
        []
        |> p_any(static fn (int $x) => $x % 2 === 1)
        |> self::is(false);

        []
        |> p_any(static fn (int $x, string $k) => $k[0] === 'a')
        |> self::is(false);

        [2, 3, 4]
        |> p_any(static fn (int $x) => $x % 2 === 1)
        |> self::is(true);

        [2, 4, 6]
        |> p_any(static fn (int $x) => $x % 2 === 1)
        |> self::is(false);

        ['aa' => 1, 'bb' => 2, 'cc' => 3]
        |> p_any(static fn (int $x, string $k) => $k[0] === 'b')
        |> self::is(true);

        ['aa' => 1, 'bb' => 2, 'cc' => 3]
        |> p_any(static fn (int $x, string $k) => $k[0] === 'd')
        |> self::is(false);
    }

    public function test_p_any_with_iterators(): void
    {
        new ArrayIterator([])
        |> p_any(static fn (int $x) => $x % 2 === 1)
        |> self::is(false);

        new ArrayIterator([])
        |> p_any(static fn (int $x, string $k) => $k[0] === 'a')
        |> self::is(false);

        new ArrayIterator([2, 3, 4])
        |> p_any(static fn (int $x) => $x % 2 === 1)
        |> self::is(true);

        new ArrayIterator([2, 4, 6])
        |> p_any(static fn (int $x) => $x % 2 === 1)
        |> self::is(false);

        new ArrayIterator(['aa' => 1, 'bb' => 2, 'cc' => 3])
        |> p_any(static fn (int $x, string $k) => $k[0] === 'b')
        |> self::is(true);

        new ArrayIterator(['aa' => 1, 'bb' => 2, 'cc' => 3])
        |> p_any(static fn (int $x, string $k) => $k[0] === 'd')
        |> self::is(false);
    }

    public function test_p_any_without_a_predicate(): void
    {
        []
        |> p_any()
        |> self::is(false);

        [1, 2]
        |> p_any()
        |> self::is(true);

        new UniterableArrayIterator([])
        |> p_any()
        |> self::is(false);

        new UniterableArrayIterator([1, 2])
        |> p_any()
        |> self::is(true);

        new SimpleIterator([])
        |> p_any()
        |> self::is(false);

        new SimpleIterator([1, 2])
        |> p_any()
        |> self::is(true);
    }
}
