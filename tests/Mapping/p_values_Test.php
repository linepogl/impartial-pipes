<?php

declare(strict_types=1);

namespace ImpartialPipes\Tests\Mapping;

use PHPUnit\Framework\TestCase;
use PHPUnitMetaConstraints\Util\PHPUnitMetaConstraintsTrait;

use function ImpartialPipes\p_values;
use function ImpartialPipes\pipe;

/**
 * @internal
 */
final class p_values_Test extends TestCase
{
    use PHPUnitMetaConstraintsTrait;

    public function test_p_values(): void
    {
        pipe([])
        ->to(p_values())
        ->to(self::iteratesLike([], rewind: true));

        pipe([1, 2, 3, 4])
        ->to(p_values())
        ->to(self::iteratesLike([1, 2, 3, 4], rewind: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_values())
        ->to(self::iteratesLike([1, 2, 3, 4], rewind: true));
    }
}
