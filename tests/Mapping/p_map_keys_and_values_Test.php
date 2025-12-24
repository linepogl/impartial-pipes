<?php

declare(strict_types=1);

namespace ImpartialPipes\Tests\Mapping;

use ImpartialPipes\Tests\ConcatIterator;
use PHPUnit\Framework\TestCase;
use PHPUnitMetaConstraints\Util\PHPUnitMetaConstraintsTrait;

use function ImpartialPipes\p_map_keys_and_values;

/**
 * @internal
 */
final class p_map_keys_and_values_Test extends TestCase
{
    use PHPUnitMetaConstraintsTrait;

    public function test_p_map_keys_and_values(): void
    {
        []
        |> p_map_keys_and_values(fn (int $x) => $x * $x, fn (int $x) => $x * $x * $x)
        |> self::iteratesLike([], rewind: true);

        [1, 2, 3, 4]
        |> p_map_keys_and_values(fn (int $x) => $x * $x, fn (int $x) => $x * $x * $x)
        |> self::iteratesLike([1 => 1, 4 => 8, 9 => 27, 16 => 64], rewind: true);

        ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]
        |> p_map_keys_and_values(fn (int $x) => $x * $x, fn (int $x) => $x * $x * $x)
        |> self::iteratesLike([1 => 1, 4 => 8, 9 => 27, 16 => 64], rewind: true);

        ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]
        |> p_map_keys_and_values(fn (int $x, string $k) => $x . $k, fn (int $x, string $k) => $k . $x)
        |> self::iteratesLike(['1a' => 'a1', '2b' => 'b2', '3c' => 'c3', '4d' => 'd4'], rewind: true);

        ['a' => 1, 'b' => 1, 'c' => 2, 'd' => 2]
        |> p_map_keys_and_values(fn (int $x) => $x * $x, fn (int $x, string $k) => $k)
        |> self::iteratesLike(new ConcatIterator([1 => 'a'], [1 => 'b'], [4 => 'c'], [4 => 'd']), rewind: true);
    }
}
