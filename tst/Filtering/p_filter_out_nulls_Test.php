<?php

declare(strict_types=1);

namespace Tests\Filtering;

use PHPUnit\Framework\TestCase;
use PHPUnitMetaConstraints\Util\PHPUnitMetaConstraintsTrait;

use function ImpartialPipes\p_filter_out_nulls;
use function ImpartialPipes\pipe;

/**
 * @internal
 */
final class p_filter_out_nulls_Test extends TestCase
{
    use PHPUnitMetaConstraintsTrait;

    public function test_p_filter_out_nulls(): void
    {
        pipe([])
        ->to(p_filter_out_nulls())
        ->to(self::iteratesLike([], rewind: true));

        pipe([])
        ->to(p_filter_out_nulls(preserveKeys: true))
        ->to(self::iteratesLike([], rewind: true));

        pipe(['a' => 1, 'b' => null, 'c' => 3, 'd' => null])
        ->to(p_filter_out_nulls())
        ->to(self::iteratesLike([1, 3], rewind: true));

        pipe(['a' => 1, 'b' => null, 'c' => 3, 'd' => null])
        ->to(p_filter_out_nulls(preserveKeys: true))
        ->to(self::iteratesLike(['a' => 1, 'c' => 3], rewind: true));
    }
}
