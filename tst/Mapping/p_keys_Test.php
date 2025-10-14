<?php

declare(strict_types=1);

namespace Tests\Mapping;

use PHPUnit\Framework\TestCase;
use PHPUnitMetaConstraints\Util\PhpUnitMetaConstraintsTrait;

use function ImpartialPipes\p_keys;
use function ImpartialPipes\pipe;

/**
 * @internal
 */
final class p_keys_Test extends TestCase
{
    use PhpunitMetaConstraintsTrait;

    public function test_p_keys(): void
    {
        pipe([])
        ->to(p_keys())
        ->to(self::iteratesLike([], rewind: true));

        pipe([1, 2, 3])
        ->to(p_keys())
        ->to(self::iteratesLike([0, 1, 2], rewind: true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_keys())
        ->to(self::iteratesLike(['a', 'b', 'c', 'd'], rewind: true));
    }
}
