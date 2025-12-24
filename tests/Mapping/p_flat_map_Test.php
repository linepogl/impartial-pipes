<?php

declare(strict_types=1);

namespace ImpartialPipes\Tests\Mapping;

use PHPUnit\Framework\TestCase;
use PHPUnitMetaConstraints\Util\PHPUnitMetaConstraintsTrait;

use function ImpartialPipes\p_flat_map;

/**
 * @internal
 */
final class p_flat_map_Test extends TestCase
{
    use PHPUnitMetaConstraintsTrait;

    public function test_p_flat_map(): void
    {
        []
        |> p_flat_map(fn (int $x) => [$x, $x])
        |> self::iteratesLike([], rewind: true);

        ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]
        |> p_flat_map(fn (int $x) => [$x, $x])
        |> self::iteratesLike([1, 1, 2, 2, 3, 3, 4, 4], rewind: true);

        ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]
        |> p_flat_map(fn (int $x, string $k) => [$x, $k])
        |> self::iteratesLike([1, 'a', 2, 'b', 3, 'c', 4, 'd'], rewind: true);
    }
}
