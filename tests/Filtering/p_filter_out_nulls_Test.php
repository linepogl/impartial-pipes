<?php

declare(strict_types=1);

namespace ImpartialPipes\Tests\Filtering;

use PHPUnit\Framework\TestCase;
use PHPUnitMetaConstraints\Util\PHPUnitMetaConstraintsTrait;

use function ImpartialPipes\p_filter_out_nulls;

/**
 * @internal
 */
final class p_filter_out_nulls_Test extends TestCase
{
    use PHPUnitMetaConstraintsTrait;

    public function test_p_filter_out_nulls(): void
    {
        []
        |> p_filter_out_nulls()
        |> self::iteratesLike([], rewind: true);

        []
        |> p_filter_out_nulls(preserveKeys: true)
        |> self::iteratesLike([], rewind: true);

        ['a' => 1, 'b' => null, 'c' => 3, 'd' => null]
        |> p_filter_out_nulls()
        |> self::iteratesLike([1, 3], rewind: true);

        ['a' => 1, 'b' => null, 'c' => 3, 'd' => null]
        |> p_filter_out_nulls(preserveKeys: true)
        |> self::iteratesLike(['a' => 1, 'c' => 3], rewind: true);
    }
}
