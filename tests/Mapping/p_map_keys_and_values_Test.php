<?php

declare(strict_types=1);

namespace ImpartialPipes\Tests\Mapping;

use ImpartialPipes\Tests\ConcatIterator;
use PHPUnit\Framework\TestCase;
use PHPUnitMetaConstraints\Util\PHPUnitMetaConstraintsTrait;

use function ImpartialPipes\p_map_keys_and_values;
use function ImpartialPipes\pipe;

/**
 * @internal
 */
final class p_map_keys_and_values_Test extends TestCase
{
    use PHPUnitMetaConstraintsTrait;

    public function test_p_map_keys_and_values(): void
    {
        pipe([])
        ->to(p_map_keys_and_values(fn (int $x) => $x * $x, fn (int $x) => $x * $x * $x))
        ->to(self::iteratesLike([], rewind: true));

        pipe([1, 2, 3, 4])
        ->to(p_map_keys_and_values(fn (int $x) => $x * $x, fn (int $x) => $x * $x * $x))
        ->to(self::iteratesLike([1 => 1, 4 => 8, 9 => 27, 16 => 64], rewind: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_map_keys_and_values(fn (int $x) => $x * $x, fn (int $x) => $x * $x * $x))
        ->to(self::iteratesLike([1 => 1, 4 => 8, 9 => 27, 16 => 64], rewind: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_map_keys_and_values(fn (int $x, string $k) => $x . $k, fn (int $x, string $k) => $k . $x))
        ->to(self::iteratesLike(['1a' => 'a1', '2b' => 'b2', '3c' => 'c3', '4d' => 'd4'], rewind: true));

        pipe(['a' => 1, 'b' => 1, 'c' => 2, 'd' => 2])
        ->to(p_map_keys_and_values(fn (int $x) => $x * $x, fn (int $x, string $k) => $k))
        ->to(self::iteratesLike(new ConcatIterator([1 => 'a'], [1 => 'b'], [4 => 'c'], [4 => 'd']), rewind: true));
    }
}
