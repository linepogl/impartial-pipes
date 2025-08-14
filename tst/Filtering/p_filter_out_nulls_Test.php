<?php

declare(strict_types=1);

namespace Tests\Filtering;

use PHPUnit\Framework\TestCase;

use function ImpartialPipes\p_filter_out_nulls;
use function ImpartialPipes\pipe;
use function Should\shouldIterateLike;

/**
 * @internal
 */
final class p_filter_out_nulls_Test extends TestCase
{
    public function test_p_filter_out_nulls(): void
    {
        pipe([])
        ->to(p_filter_out_nulls())
        ->to(shouldIterateLike([], repeatedly: true));

        pipe([])
        ->to(p_filter_out_nulls(preserveKeys: true))
        ->to(shouldIterateLike([], repeatedly: true));

        pipe(['a' => 1, 'b' => null, 'c' => 3, 'd' => null])
        ->to(p_filter_out_nulls())
        ->to(shouldIterateLike([1, 3], repeatedly: true));

        pipe(['a' => 1, 'b' => null, 'c' => 3, 'd' => null])
        ->to(p_filter_out_nulls(preserveKeys: true))
        ->to(shouldIterateLike(['a' => 1, 'c' => 3], repeatedly: true));
    }
}
