<?php

declare(strict_types=1);

namespace Tests\Reducing;

use ArrayIterator;
use PHPUnit\Framework\TestCase;
use Tests\SimpleIterator;
use Tests\UniterableArrayIterator;

use function ImpartialPipes\p_any;
use function ImpartialPipes\pipe;
use function Tests\shouldBe;

/**
 * @internal
 */
final class p_any_Test extends TestCase
{
    public function test_p_any_with_arrays(): void
    {
        pipe([])
        ->to(p_any(static fn (int $x) => $x % 2 === 1))
        ->to(shouldBe(false));

        pipe([])
        ->to(p_any(static fn (int $x, string $k) => $k[0] === 'a'))
        ->to(shouldBe(false));

        pipe([2, 3, 4])
        ->to(p_any(static fn (int $x) => $x % 2 === 1))
        ->to(shouldBe(true));

        pipe([2, 4, 6])
        ->to(p_any(static fn (int $x) => $x % 2 === 1))
        ->to(shouldBe(false));

        pipe(['aa' => 1, 'bb' => 2, 'cc' => 3])
        ->to(p_any(static fn (int $x, string $k) => $k[0] === 'b'))
        ->to(shouldBe(true));

        pipe(['aa' => 1, 'bb' => 2, 'cc' => 3])
        ->to(p_any(static fn (int $x, string $k) => $k[0] === 'd'))
        ->to(shouldBe(false));
    }

    public function test_p_any_with_iterators(): void
    {
        pipe(new ArrayIterator([]))
        ->to(p_any(static fn (int $x) => $x % 2 === 1))
        ->to(shouldBe(false));

        pipe(new ArrayIterator([]))
        ->to(p_any(static fn (int $x, string $k) => $k[0] === 'a'))
        ->to(shouldBe(false));

        pipe(new ArrayIterator([2, 3, 4]))
        ->to(p_any(static fn (int $x) => $x % 2 === 1))
        ->to(shouldBe(true));

        pipe(new ArrayIterator([2, 4, 6]))
        ->to(p_any(static fn (int $x) => $x % 2 === 1))
        ->to(shouldBe(false));

        pipe(new ArrayIterator(['aa' => 1, 'bb' => 2, 'cc' => 3]))
        ->to(p_any(static fn (int $x, string $k) => $k[0] === 'b'))
        ->to(shouldBe(true));

        pipe(new ArrayIterator(['aa' => 1, 'bb' => 2, 'cc' => 3]))
        ->to(p_any(static fn (int $x, string $k) => $k[0] === 'd'))
        ->to(shouldBe(false));
    }

    public function test_p_any_without_a_predicate(): void
    {
        pipe([])
        ->to(p_any())
        ->to(shouldBe(false));

        pipe([1, 2])
        ->to(p_any())
        ->to(shouldBe(true));

        pipe(new UniterableArrayIterator([]))
        ->to(p_any())
        ->to(shouldBe(false));

        pipe(new UniterableArrayIterator([1, 2]))
        ->to(p_any())
        ->to(shouldBe(true));

        pipe(new SimpleIterator([]))
        ->to(p_any())
        ->to(shouldBe(false));

        pipe(new SimpleIterator([1, 2]))
        ->to(p_any())
        ->to(shouldBe(true));
    }
}
