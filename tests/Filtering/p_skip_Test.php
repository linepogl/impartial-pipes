<?php

declare(strict_types=1);

namespace ImpartialPipes\Tests\Filtering;

use PHPUnit\Framework\TestCase;
use PHPUnitMetaConstraints\Util\PHPUnitMetaConstraintsTrait;

use function ImpartialPipes\p_skip;
use function ImpartialPipes\pipe;

/**
 * @internal
 */
final class p_skip_Test extends TestCase
{
    use PHPUnitMetaConstraintsTrait;

    public function test_p_skip(): void
    {
        pipe([])
        ->to(p_skip(2))
        ->to(self::iteratesLike([], rewind: true));

        pipe([])
        ->to(p_skip(2, preserveKeys: true))
        ->to(self::iteratesLike([], rewind: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_skip(2))
        ->to(self::iteratesLike([3, 4], rewind: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_skip(2, preserveKeys: true))
        ->to(self::iteratesLike(['c' => 3, 'd' => 4], rewind: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_skip(-2))
        ->to(self::iteratesLike([1, 2, 3, 4], rewind: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_skip(-2, preserveKeys: true))
        ->to(self::iteratesLike(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4], rewind: true));
    }
}
