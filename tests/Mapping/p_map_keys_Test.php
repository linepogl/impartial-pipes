<?php

declare(strict_types=1);

namespace ImpartialPipes\Tests\Mapping;

use ImpartialPipes\Tests\ConcatIterator;
use PHPUnit\Framework\TestCase;
use PHPUnitMetaConstraints\Util\PHPUnitMetaConstraintsTrait;

use function ImpartialPipes\p_map_keys;

/**
 * @internal
 */
final class p_map_keys_Test extends TestCase
{
    use PHPUnitMetaConstraintsTrait;

    public function test_p_map_keys(): void
    {
        []
        |> p_map_keys(fn (int $x) => $x * $x)
        |> self::iteratesLike([], rewind: true);

        [1, 2, 3, 4]
        |> p_map_keys(fn (int $x) => $x * $x)
        |> self::iteratesLike([1 => 1, 4 => 2, 9 => 3, 16 => 4], rewind: true);

        ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]
        |> p_map_keys(fn (int $x) => $x * $x)
        |> self::iteratesLike([1 => 1, 4 => 2, 9 => 3, 16 => 4], rewind: true);

        ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]
        |> p_map_keys(fn (int $x, string $k) => $x . $k)
        |> self::iteratesLike(['1a' => 1, '2b' => 2, '3c' => 3, '4d' => 4], rewind: true);

        ['a' => 1, 'b' => 1, 'c' => 2, 'd' => 2]
        |> p_map_keys(fn (int $x) => $x * $x)
        |> self::iteratesLike(new ConcatIterator([1 => 1], [1 => 1], [4 => 2], [4 => 2]), rewind: true);
    }
}
