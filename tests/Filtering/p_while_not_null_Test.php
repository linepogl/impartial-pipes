<?php

declare(strict_types=1);

namespace ImpartialPipes\Tests\Filtering;

use PHPUnit\Framework\TestCase;
use PHPUnitMetaConstraints\Util\PHPUnitMetaConstraintsTrait;

use function ImpartialPipes\p_while_not_null;

/**
 * @internal
 */
final class p_while_not_null_Test extends TestCase
{
    use PHPUnitMetaConstraintsTrait;

    public function test_p_while_not_null(): void
    {
        []
        |> p_while_not_null()
        |> self::iteratesLike([], rewind: true);

        []
        |> p_while_not_null(preserveKeys: true)
        |> self::iteratesLike([], rewind: true);

        ['a' => 1, 'b' => 2, 'c' => null, 'd' => 4]
        |> p_while_not_null()
        |> self::iteratesLike([1, 2], rewind: true);

        ['a' => 1, 'b' => 2, 'c' => null, 'd' => 4]
        |> p_while_not_null(preserveKeys: true)
        |> self::iteratesLike(['a' => 1, 'b' => 2], rewind: true);
    }
}
