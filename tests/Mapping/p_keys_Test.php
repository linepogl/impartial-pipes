<?php

declare(strict_types=1);

namespace ImpartialPipes\Tests\Mapping;

use PHPUnit\Framework\TestCase;
use PHPUnitMetaConstraints\Util\PHPUnitMetaConstraintsTrait;

use function ImpartialPipes\p_keys;

/**
 * @internal
 */
final class p_keys_Test extends TestCase
{
    use PHPUnitMetaConstraintsTrait;

    public function test_p_keys(): void
    {
        []
        |> p_keys()
        |> self::iteratesLike([], rewind: true);

        [1, 2, 3]
        |> p_keys()
        |> self::iteratesLike([0, 1, 2], rewind: true);

        ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]
        |> p_keys()
        |> self::iteratesLike(['a', 'b', 'c', 'd'], rewind: true);
    }
}
