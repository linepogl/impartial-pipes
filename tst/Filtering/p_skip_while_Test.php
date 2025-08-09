<?php

declare(strict_types=1);

namespace Tests\Filtering;

use Tests\UnitTestCase;

use function ImpartialPipes\p_skip_while;
use function ImpartialPipes\pipe;
use function Tests\p_assert_iterates_like;

/**
 * @internal
 */
final class p_skip_while_Test extends UnitTestCase
{
    public function test_p_skip_while(): void
    {
        pipe([])
        ->to(p_skip_while(fn (int $x) => $x % 2 === 1))
        ->to(p_assert_iterates_like([]));

        pipe([])
        ->to(p_skip_while(fn (int $x) => $x % 2 === 1, preserveKeys: true))
        ->to(p_assert_iterates_like([]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_skip_while(fn (int $x) => $x % 2 === 1))
        ->to(p_assert_iterates_like([2, 3, 4]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_skip_while(fn (int $x) => $x % 2 === 1, preserveKeys: true))
        ->to(p_assert_iterates_like(['b' => 2, 'c' => 3, 'd' => 4]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_skip_while(fn (int $x, string $k) => $k === 'a'))
        ->to(p_assert_iterates_like([2, 3, 4]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_skip_while(fn (int $x, string $k) => $k === 'a', preserveKeys: true))
        ->to(p_assert_iterates_like(['b' => 2, 'c' => 3, 'd' => 4]));
    }
}
