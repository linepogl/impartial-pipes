<?php

declare(strict_types=1);

namespace Tests\Filtering;

use PHPUnit\Framework\TestCase;
use PHPUnitMetaConstraints\Util\PhpUnitMetaConstraintsTrait;

use function ImpartialPipes\p_while;
use function ImpartialPipes\pipe;

/**
 * @internal
 */
final class p_while_Test extends TestCase
{
    use PhpunitMetaConstraintsTrait;

    public function test_p_while(): void
    {
        pipe([])
        ->to(p_while(fn (int $x) => $x % 2 === 1))
        ->to(self::iteratesLike([], rewind: true));

        pipe([])
        ->to(p_while(fn (int $x) => $x % 2 === 1, preserveKeys: true))
        ->to(self::iteratesLike([], rewind: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_while(fn (int $x) => $x % 2 === 1))
        ->to(self::iteratesLike([1], rewind: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_while(fn (int $x) => $x % 2 === 1, preserveKeys: true))
        ->to(self::iteratesLike(['a' => 1], rewind: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_while(fn (int $x, string $k) => $k === 'a'))
        ->to(self::iteratesLike([1], rewind: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_while(fn (int $x, string $k) => $k === 'a', preserveKeys: true))
        ->to(self::iteratesLike(['a' => 1], rewind: true));
    }
}
