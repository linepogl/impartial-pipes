<?php

declare(strict_types=1);

namespace ImpartialPipes\Tests\Filtering;

use PHPUnit\Framework\TestCase;
use PHPUnitMetaConstraints\Util\PHPUnitMetaConstraintsTrait;

use function ImpartialPipes\p_skip_while;
use function ImpartialPipes\pipe;

/**
 * @internal
 */
final class p_skip_while_Test extends TestCase
{
    use PHPUnitMetaConstraintsTrait;

    public function test_p_skip_while(): void
    {
        pipe([])
        ->to(p_skip_while(fn (int $x) => $x % 2 === 1))
        ->to(self::iteratesLike([], rewind: true));

        pipe([])
        ->to(p_skip_while(fn (int $x) => $x % 2 === 1, preserveKeys: true))
        ->to(self::iteratesLike([], rewind: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_skip_while(fn (int $x) => $x % 2 === 1))
        ->to(self::iteratesLike([2, 3, 4], rewind: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_skip_while(fn (int $x) => $x % 2 === 1, preserveKeys: true))
        ->to(self::iteratesLike(['b' => 2, 'c' => 3, 'd' => 4], rewind: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_skip_while(fn (int $x, string $k) => $k === 'a'))
        ->to(self::iteratesLike([2, 3, 4], rewind: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_skip_while(fn (int $x, string $k) => $k === 'a', preserveKeys: true))
        ->to(self::iteratesLike(['b' => 2, 'c' => 3, 'd' => 4], rewind: true));
    }
}
