<?php

declare(strict_types=1);

namespace ImpartialPipes\Tests\Filtering;

use PHPUnit\Framework\TestCase;
use PHPUnitMetaConstraints\Util\PHPUnitMetaConstraintsTrait;

use function ImpartialPipes\p_skip;

/**
 * @internal
 */
final class p_skip_Test extends TestCase
{
    use PHPUnitMetaConstraintsTrait;

    public function test_p_skip(): void
    {
        []
        |> p_skip(2)
        |> self::iteratesLike([], rewind: true);

        []
        |> p_skip(2, preserveKeys: true)
        |> self::iteratesLike([], rewind: true);

        ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]
        |> p_skip(2)
        |> self::iteratesLike([3, 4], rewind: true);

        ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]
        |> p_skip(2, preserveKeys: true)
        |> self::iteratesLike(['c' => 3, 'd' => 4], rewind: true);

        ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]
        |> p_skip(-2)
        |> self::iteratesLike([1, 2, 3, 4], rewind: true);

        ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]
        |> p_skip(-2, preserveKeys: true)
        |> self::iteratesLike(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4], rewind: true);
    }
}
