<?php

declare(strict_types=1);

namespace Tests\Combining;

use ArrayIterator;
use ImpartialPipes\LazyRewindableIterator;
use Tests\SimpleIterator;
use Tests\UniterableArrayIterator;
use Tests\UnitTestCase;

use function ImpartialPipes\p_implode;
use function ImpartialPipes\p_union;

/**
 * @internal
 */
final class p_union_Test extends UnitTestCase
{
    public function test_p_union(): void
    {
        $this
            ->expect([])
            ->pipe(p_union([]))
            ->toIterateLike([]);
        $this
            ->expect([])
            ->pipe(p_union([], preserveKeys: true))
            ->toIterateLike([]);
        $this
            ->expect([1,2])
            ->pipe(p_union([3,4]))
            ->toIterateLike([1,2,3,4]);
        $this
            ->expect([1,2])
            ->pipe(p_union([3,4], preserveKeys: true))
            ->toIterateLike([1,2]);
        $this
            ->expect(['a'=>1,'b'=>2,'c'=>3])
            ->pipe(p_union(['b'=>22,'c'=>33,'d'=>4]))
            ->toIterateLike([1,2,3,22,33,4]);
        $this
            ->expect(['a'=>1,'b'=>2,'c'=>'3'])
            ->pipe(p_union(['b'=>2,'c'=>3,'d'=>4], preserveKeys: true))
            ->toIterateLike(['a'=>1,'b'=>2,'c'=>3,'d'=>4]);;
    }
}
