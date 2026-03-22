<?php

declare(strict_types=1);

namespace ImpartialPipes\Tests\Filtering;

use PHPUnit\Framework\TestCase;
use PHPUnitMetaConstraints\Util\PHPUnitMetaConstraintsTrait;

use function ImpartialPipes\p_compact;
use function ImpartialPipes\p_compact_assoc;

/**
 * @internal
 */
final class p_compact_Test extends TestCase
{
    use PHPUnitMetaConstraintsTrait;

    public function test_p_compact(): void
    {
        []
        |> p_compact()
        |> self::iteratesLike([], rewind: true);

        []
        |> p_compact_assoc()
        |> self::iteratesLike([], rewind: true);

        ['a' => 1, 'b' => null, 'c' => 3, 'd' => null]
        |> p_compact()
        |> self::iteratesLike([1, 3], rewind: true);

        ['a' => 1, 'b' => null, 'c' => 3, 'd' => null]
        |> p_compact_assoc()
        |> self::iteratesLike(['a' => 1, 'c' => 3], rewind: true);
    }
}
