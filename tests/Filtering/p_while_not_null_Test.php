<?php

declare(strict_types=1);

namespace ImpartialPipes\Tests\Filtering;

use PHPUnit\Framework\TestCase;
use PHPUnitMetaConstraints\Util\PHPUnitMetaConstraintsTrait;

use function ImpartialPipes\p_while_not_null;
use function ImpartialPipes\pipe;

/**
 * @internal
 */
final class p_while_not_null_Test extends TestCase
{
    use PHPUnitMetaConstraintsTrait;

    public function test_p_while_not_null(): void
    {
        pipe([])
        ->to(p_while_not_null())
        ->to(self::iteratesLike([], rewind: true));

        pipe([])
        ->to(p_while_not_null(preserveKeys: true))
        ->to(self::iteratesLike([], rewind: true));

        pipe(['a' => 1, 'b' => 2, 'c' => null, 'd' => 4])
        ->to(p_while_not_null())
        ->to(self::iteratesLike([1, 2], rewind: true));

        pipe(['a' => 1, 'b' => 2, 'c' => null, 'd' => 4])
        ->to(p_while_not_null(preserveKeys: true))
        ->to(self::iteratesLike(['a' => 1, 'b' => 2], rewind: true));
    }
}
