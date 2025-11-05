<?php

declare(strict_types=1);

namespace ImpartialPipes\Tests\Mapping;

use PHPUnit\Framework\TestCase;
use PHPUnitMetaConstraints\Util\PHPUnitMetaConstraintsTrait;

use function ImpartialPipes\p_group_by;
use function ImpartialPipes\pipe;

/**
 * @internal
 */
final class p_group_by_Test extends TestCase
{
    use PHPUnitMetaConstraintsTrait;

    public function test_p_group_by(): void
    {
        pipe([])
        ->to(p_group_by(fn (int $x) => $x % 2))
        ->to(self::iteratesLike([], rewind: true));

        pipe([])
        ->to(p_group_by(fn (int $x) => $x % 2, preserveKeys: true))
        ->to(self::iteratesLike([], rewind: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_group_by(fn (int $x) => $x % 2))
        ->to(self::iteratesLike([1 => [1, 3], 0 => [2, 4]], rewind: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_group_by(fn (int $x) => $x % 2, preserveKeys: true))
        ->to(self::iteratesLike([1 => ['a' => 1, 'c' => 3], 0 => ['b' => 2, 'd' => 4]], rewind: true));

        pipe(['a' => 1, 'aa' => 2, 'b' => 3, 'bb' => 4])
        ->to(p_group_by(fn (int $x, string $k) => $k[0]))
        ->to(self::iteratesLike(['a' => [1, 2], 'b' => [3, 4]], rewind: true));

        pipe(['a' => 1, 'aa' => 2, 'b' => 3, 'bb' => 4])
        ->to(p_group_by(fn (int $x, string $k) => $k[0], preserveKeys: true))
        ->to(self::iteratesLike(['a' => ['a' => 1, 'aa' => 2], 'b' => ['b' => 3, 'bb' => 4]], rewind: true));
    }
}
