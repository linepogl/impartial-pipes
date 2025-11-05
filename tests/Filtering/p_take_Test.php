<?php

declare(strict_types=1);

namespace ImpartialPipes\Tests\Filtering;

use PHPUnit\Framework\TestCase;
use PHPUnitMetaConstraints\Util\PHPUnitMetaConstraintsTrait;

use function ImpartialPipes\p_take;
use function ImpartialPipes\pipe;

/**
 * @internal
 */
final class p_take_Test extends TestCase
{
    use PHPUnitMetaConstraintsTrait;

    public function test_p_take(): void
    {
        pipe([])
        ->to(p_take(2))
        ->to(self::iteratesLike([], rewind: true));

        pipe([])
        ->to(p_take(2, preserveKeys: true))
        ->to(self::iteratesLike([], rewind: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_take(2))
        ->to(self::iteratesLike([1, 2], rewind: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_take(2, preserveKeys: true))
        ->to(self::iteratesLike(['a' => 1, 'b' => 2], rewind: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_take(-2))
        ->to(self::iteratesLike([], rewind: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_take(-2, preserveKeys: true))
        ->to(self::iteratesLike([], rewind: true));
    }
}
