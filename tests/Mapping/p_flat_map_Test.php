<?php

declare(strict_types=1);

namespace ImpartialPipes\Tests\Mapping;

use PHPUnit\Framework\TestCase;
use PHPUnitMetaConstraints\Util\PHPUnitMetaConstraintsTrait;

use function ImpartialPipes\p_flat_map;
use function ImpartialPipes\pipe;

/**
 * @internal
 */
final class p_flat_map_Test extends TestCase
{
    use PHPUnitMetaConstraintsTrait;

    public function test_p_flat_map(): void
    {
        pipe([])
        ->to(p_flat_map(fn (int $x) => [$x, $x]))
        ->to(self::iteratesLike([], rewind: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_flat_map(fn (int $x) => [$x, $x]))
        ->to(self::iteratesLike([1, 1, 2, 2, 3, 3, 4, 4], rewind: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_flat_map(fn (int $x, string $k) => [$x, $k]))
        ->to(self::iteratesLike([1, 'a', 2, 'b', 3, 'c', 4, 'd'], rewind: true));
    }
}
