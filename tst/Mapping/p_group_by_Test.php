<?php

declare(strict_types=1);

namespace Tests\Mapping;

use PHPUnit\Framework\TestCase;

use function ImpartialPipes\p_group_by;
use function ImpartialPipes\pipe;
use function Tests\p_assert_iterates_like;

/**
 * @internal
 */
final class p_group_by_Test extends TestCase
{
    public function test_p_group_by(): void
    {
        pipe([])
        ->to(p_group_by(fn (int $x) => $x % 2))
        ->to(p_assert_iterates_like([]));

        pipe([])
        ->to(p_group_by(fn (int $x) => $x % 2, preserveKeys: true))
        ->to(p_assert_iterates_like([]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_group_by(fn (int $x) => $x % 2))
        ->to(p_assert_iterates_like([1 => [1, 3], 0 => [2, 4]]));

        pipe(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4])
        ->to(p_group_by(fn (int $x) => $x % 2, preserveKeys: true))
        ->to(p_assert_iterates_like([1 => ['a' => 1, 'c' => 3], 0 => ['b' => 2, 'd' => 4]]));

        pipe(['a' => 1, 'aa' => 2, 'b' => 3, 'bb' => 4])
        ->to(p_group_by(fn (int $x, string $k) => $k[0]))
        ->to(p_assert_iterates_like(['a' => [1, 2], 'b' => [3, 4]]));

        pipe(['a' => 1, 'aa' => 2, 'b' => 3, 'bb' => 4])
        ->to(p_group_by(fn (int $x, string $k) => $k[0], preserveKeys: true))
        ->to(p_assert_iterates_like(['a' => ['a' => 1, 'aa' => 2], 'b' => ['b' => 3, 'bb' => 4]]));
    }
}
