<?php

declare(strict_types=1);

namespace ImpartialPipes\Tests\Filtering;

use PHPUnit\Framework\TestCase;
use PHPUnitMetaConstraints\Util\PHPUnitMetaConstraintsTrait;

use function ImpartialPipes\p_reject;
use function ImpartialPipes\p_reject_assoc;

/**
 * @internal
 */
final class p_reject_Test extends TestCase
{
    use PHPUnitMetaConstraintsTrait;

    public function test_p_reject(): void
    {
        []
        |> p_reject(fn (int $x) => $x % 2 === 0)
        |> self::iteratesLike([], rewind: true);

        []
        |> p_reject_assoc(fn (int $x) => $x % 2 === 0)
        |> self::iteratesLike([], rewind: true);

        ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]
        |> p_reject(fn (int $x) => $x % 2 === 0)
        |> self::iteratesLike([1, 3], rewind: true);

        ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]
        |> p_reject_assoc(fn (int $x) => $x % 2 === 0)
        |> self::iteratesLike(['a' => 1, 'c' => 3], rewind: true);

        ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]
        |> p_reject(fn (int $x, string $k) => $k === 'b')
        |> self::iteratesLike([1, 3, 4], rewind: true);

        ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]
        |> p_reject_assoc(fn (int $x, string $k) => $k === 'b')
        |> self::iteratesLike(['a' => 1, 'c' => 3, 'd' => 4], rewind: true);
    }
}
