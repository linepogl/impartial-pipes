<?php

declare(strict_types=1);

namespace Tests\Reducing;

use ArrayIterator;
use PHPUnit\Framework\TestCase;

use function ImpartialPipes\p_all;
use function ImpartialPipes\pipe;
use function Tests\shouldBe;

/**
 * @internal
 */
final class p_all_Test extends TestCase
{
    public function test_p_all_with_arrays(): void
    {
        pipe([])
        ->to(p_all(static fn (int $x) => $x % 2 === 1))
        ->to(shouldBe(true));

        pipe([])
        ->to(p_all(static fn (int $x, string $k) => $k[0] === 'a'))
        ->to(shouldBe(true));

        pipe([1, 3, 5])
        ->to(p_all(static fn (int $x) => $x % 2 === 1))
        ->to(shouldBe(true));

        pipe([1, 2, 5])
        ->to(p_all(static fn (int $x) => $x % 2 === 1))
        ->to(shouldBe(false));

        pipe(['a' => 1, 'aa' => 2, 'aaa' => 3])
        ->to(p_all(static fn (int $x, string $k) => $k[0] === 'a'))
        ->to(shouldBe(true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3])
        ->to(p_all(static fn (int $x, string $k) => $k[0] === 'a'))
        ->to(shouldBe(false));
    }

    public function test_p_all_with_iterators(): void
    {
        pipe(new ArrayIterator([]))
        ->to(p_all(static fn (int $x) => $x % 2 === 1))
        ->to(shouldBe(true));

        pipe(new ArrayIterator([]))
        ->to(p_all(static fn (int $x, string $k) => $k[0] === 'a'))
        ->to(shouldBe(true));

        pipe(new ArrayIterator([1, 3, 5]))
        ->to(p_all(static fn (int $x) => $x % 2 === 1))
        ->to(shouldBe(true));

        pipe(new ArrayIterator([1, 2, 5]))
        ->to(p_all(static fn (int $x) => $x % 2 === 1))
        ->to(shouldBe(false));

        pipe(new ArrayIterator(['a' => 1, 'aa' => 2, 'aaa' => 3]))
        ->to(p_all(static fn (int $x, string $k) => $k[0] === 'a'))
        ->to(shouldBe(true));

        pipe(new ArrayIterator(['a' => 1, 'b' => 2, 'c' => 3]))
        ->to(p_all(static fn (int $x, string $k) => $k[0] === 'a'))
        ->to(shouldBe(false));
    }
}
