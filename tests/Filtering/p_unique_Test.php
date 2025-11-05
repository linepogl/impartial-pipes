<?php

declare(strict_types=1);

namespace ImpartialPipes\Tests\Filtering;

use PHPUnit\Framework\TestCase;
use PHPUnitMetaConstraints\Util\PHPUnitMetaConstraintsTrait;

use function ImpartialPipes\p_unique;
use function ImpartialPipes\pipe;

/**
 * @internal
 */
final class p_unique_Test extends TestCase
{
    use PHPUnitMetaConstraintsTrait;

    public function test_p_unique(): void
    {
        pipe([])
        ->to(p_unique())
        ->to(self::iteratesLike([], rewind: true));

        pipe([])
        ->to(p_unique(preserveKeys: true))
        ->to(self::iteratesLike([], rewind: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 1, 'd' => 4])
        ->to(p_unique())
        ->to(self::iteratesLike([1, 2, 4], rewind: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 1, 'd' => 4])
        ->to(p_unique(preserveKeys: true))
        ->to(self::iteratesLike(['a' => 1, 'b' => 2, 'd' => 4], rewind: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_unique(static fn (int $x) => $x % 2))
        ->to(self::iteratesLike([1, 2], rewind: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_unique(static fn (int $x) => $x % 2, preserveKeys: true))
        ->to(self::iteratesLike(['a' => 1, 'b' => 2], rewind: true));

        pipe(['a' => 1, 'aa' => 2, 'b' => 3, 'bb' => 4])
        ->to(p_unique(static fn (int $x, string $k) => $k[0]))
        ->to(self::iteratesLike([1, 3], rewind: true));

        pipe(['a' => 1, 'aa' => 2, 'b' => 3, 'bb' => 4])
        ->to(p_unique(static fn (int $x, string $k) => $k[0], preserveKeys: true))
        ->to(self::iteratesLike(['a' => 1, 'b' => 3], rewind: true));
    }
}
