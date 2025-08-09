<?php

declare(strict_types=1);

namespace Tests\Filtering;

use Tests\UnitTestCase;

use function ImpartialPipes\p_take_while;
use function Tests\p_assert_iterates_like;
use function Tests\pipe;

/**
 * @internal
 */
final class p_take_while_Test extends UnitTestCase
{
    public function test_p_take_while(): void
    {
        pipe([])
        ->to(p_take_while(fn (int $x) => $x % 2 === 1))
        ->to(p_assert_iterates_like([]));

        pipe([])
        ->to(p_take_while(fn (int $x) => $x % 2 === 1, preserveKeys: true))
        ->to(p_assert_iterates_like([]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_take_while(fn (int $x) => $x % 2 === 1))
        ->to(p_assert_iterates_like([1]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_take_while(fn (int $x) => $x % 2 === 1, preserveKeys: true))
        ->to(p_assert_iterates_like(['a' => 1]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_take_while(fn (int $x, string $k) => $k === 'a'))
        ->to(p_assert_iterates_like([1]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_take_while(fn (int $x, string $k) => $k === 'a', preserveKeys: true))
        ->to(p_assert_iterates_like(['a' => 1]));
    }
}
