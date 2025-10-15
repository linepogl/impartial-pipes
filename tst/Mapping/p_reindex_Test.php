<?php

declare(strict_types=1);

namespace Tests\Mapping;

use PHPUnit\Framework\TestCase;
use PHPUnitMetaConstraints\Util\PHPUnitMetaConstraintsTrait;
use Tests\ConcatIterator;

use function ImpartialPipes\p_reindex;
use function ImpartialPipes\pipe;

/**
 * @internal
 */
final class p_reindex_Test extends TestCase
{
    use PHPUnitMetaConstraintsTrait;

    public function test_p_reindex(): void
    {
        pipe([])
        ->to(p_reindex(fn (int $x) => $x * $x))
        ->to(self::iteratesLike([], rewind: true));

        pipe([1, 2, 3, 4])
        ->to(p_reindex(fn (int $x) => $x * $x))
        ->to(self::iteratesLike([1 => 1, 4 => 2, 9 => 3, 16 => 4], rewind: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_reindex(fn (int $x) => $x * $x))
        ->to(self::iteratesLike([1 => 1, 4 => 2, 9 => 3, 16 => 4], rewind: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_reindex(fn (int $x, string $k) => $x . $k))
        ->to(self::iteratesLike(['1a' => 1, '2b' => 2, '3c' => 3, '4d' => 4], rewind: true));

        pipe(['a' => 1, 'b' => 1, 'c' => 2, 'd' => 2])
        ->to(p_reindex(fn (int $x) => $x * $x))
        ->to(self::iteratesLike(new ConcatIterator([1 => 1], [1 => 1], [4 => 2], [4 => 2]), rewind: true));
    }
}
