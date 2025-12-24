<?php

declare(strict_types=1);

namespace ImpartialPipes\Tests\Filtering;

use PHPUnit\Framework\TestCase;
use PHPUnitMetaConstraints\Util\PHPUnitMetaConstraintsTrait;

use function ImpartialPipes\p_filter;

/**
 * @internal
 */
final class p_filter_Test extends TestCase
{
    use PHPUnitMetaConstraintsTrait;

    public function test_p_filter(): void
    {
        []
        |> p_filter(fn (int $x) => $x % 2 === 0)
        |> self::iteratesLike([], rewind: true);

        []
        |> p_filter(fn (int $x) => $x % 2 === 0, preserveKeys: true)
        |> self::iteratesLike([], rewind: true);

        ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]
        |> p_filter(fn (int $x) => $x % 2 === 0)
        |> self::iteratesLike([2, 4], rewind: true);

        ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]
        |> p_filter(fn (int $x) => $x % 2 === 0, preserveKeys: true)
        |> self::iteratesLike(['b' => 2, 'd' => 4], rewind: true);

        ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]
        |> p_filter(fn (int $x, string $k) => $k === 'b')
        |> self::iteratesLike([2], rewind: true);

        ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]
        |> p_filter(fn (int $x, string $k) => $k === 'b', preserveKeys: true)
        |> self::iteratesLike(['b' => 2], rewind: true);
    }
}
