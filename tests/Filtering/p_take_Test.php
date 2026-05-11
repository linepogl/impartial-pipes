<?php

declare(strict_types=1);

namespace ImpartialPipes\Tests\Filtering;

use PHPUnit\Framework\TestCase;
use PHPUnitMetaConstraints\Util\PHPUnitMetaConstraintsTrait;

use function ImpartialPipes\p_take;
use function ImpartialPipes\p_take_preserving_keys;

/**
 * @internal
 */
final class p_take_Test extends TestCase
{
    use PHPUnitMetaConstraintsTrait;

    public function test_p_take(): void
    {
        []
        |> p_take(2)
        |> self::iteratesLike([], rewind: true);

        []
        |> p_take_preserving_keys(2)
        |> self::iteratesLike([], rewind: true);

        ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]
        |> p_take(2)
        |> self::iteratesLike([1, 2], rewind: true);

        ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]
        |> p_take_preserving_keys(2)
        |> self::iteratesLike(['a' => 1, 'b' => 2], rewind: true);

        ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]
        |> p_take(-2)
        |> self::iteratesLike([], rewind: true);

        ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]
        |> p_take_preserving_keys(-2)
        |> self::iteratesLike([], rewind: true);
    }
}
