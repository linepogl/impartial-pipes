<?php

declare(strict_types=1);

namespace Tests\Reducing;

use ArrayIterator;
use PHPUnit\Framework\TestCase;

use function ImpartialPipes\p_last_or;
use function ImpartialPipes\pipe;
use function Tests\shouldBe;

/**
 * @internal
 */
final class p_last_or_Test extends TestCase
{
    public function test_p_last_or_with_arrays(): void
    {
        pipe([])
        ->to(p_last_or(null))
        ->to(shouldBe(null));

        pipe([])
        ->to(p_last_or(null, static fn (int $x) => $x < 3))
        ->to(shouldBe(null));

        pipe([1,2,3])
        ->to(p_last_or(null))
        ->to(shouldBe(3));

        pipe([1,2,3])
        ->to(p_last_or(null, static fn (int $x) => $x < 3))
        ->to(shouldBe(2));

        pipe([1,2,3])
        ->to(p_last_or(null, static fn (int $x) => $x > 3))
        ->to(shouldBe(null));

        pipe(['a' => 1, 'aa' => 2, 'aaa' => 3])
        ->to(p_last_or(null))
        ->to(shouldBe(3));

        pipe(['a' => 1, 'aa' => 2, 'aaa' => 3])
        ->to(p_last_or(null, static fn (int $x, string $k) => strlen($k) < 3))
        ->to(shouldBe(2));

        pipe(['a' => 1, 'aa' => 2, 'aaa' => 3])
        ->to(p_last_or(null, static fn (int $x, string $k) => strlen($k) > 3))
        ->to(shouldBe(null));
    }

    public function test_p_last_or_with_iterables(): void
    {
        pipe(new ArrayIterator([]))
        ->to(p_last_or(null))
        ->to(shouldBe(null));

        pipe(new ArrayIterator([]))
        ->to(p_last_or(null, static fn (int $x) => $x < 3))
        ->to(shouldBe(null));

        pipe(new ArrayIterator([1,2,3]))
        ->to(p_last_or(null))
        ->to(shouldBe(3));

        pipe(new ArrayIterator([1,2,3]))
        ->to(p_last_or(null, static fn (int $x) => $x < 3))
        ->to(shouldBe(2));

        pipe(new ArrayIterator([1,2,3]))
        ->to(p_last_or(null, static fn (int $x) => $x > 3))
        ->to(shouldBe(null));

        pipe(new ArrayIterator(['a' => 1, 'aa' => 2, 'aaa' => 3]))
        ->to(p_last_or(null))
        ->to(shouldBe(3));

        pipe(new ArrayIterator(['a' => 1, 'aa' => 2, 'aaa' => 3]))
        ->to(p_last_or(null, static fn (int $x, string $k) => strlen($k) < 3))
        ->to(shouldBe(2));

        pipe(new ArrayIterator(['a' => 1, 'aa' => 2, 'aaa' => 3]))
        ->to(p_last_or(null, static fn (int $x, string $k) => strlen($k) > 3))
        ->to(shouldBe(null));
    }
}
