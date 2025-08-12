<?php

declare(strict_types=1);

namespace Tests\Reducing;

use ArrayIterator;
use OutOfBoundsException;
use PHPUnit\Framework\TestCase;

use function ImpartialPipes\p_first;
use function ImpartialPipes\pipe;
use function Should\shouldBe;
use function Should\shouldThrow;

/**
 * @internal
 */
final class p_first_Test extends TestCase
{
    public function test_p_first_with_arrays(): void
    {
        shouldThrow(OutOfBoundsException::class)(
            static fn () =>
            pipe([])
            ->to(p_first())
        );

        shouldThrow(OutOfBoundsException::class)(
            static fn () =>
            pipe([])
            ->to(p_first(static fn (int $x) => $x > 1))
        );

        pipe([1,2,3])
        ->to(p_first())
        ->to(shouldBe(1));

        pipe([1,2,3])
        ->to(p_first(static fn (int $x) => $x > 1))
        ->to(shouldBe(2));

        shouldThrow(OutOfBoundsException::class)(
            static fn () =>
            pipe([1,2,3])
            ->to(p_first(static fn (int $x) => $x > 3))
        );

        pipe(['a' => 1, 'aa' => 2, 'aaa' => 3])
        ->to(p_first())
        ->to(shouldBe(1));

        pipe(['a' => 1, 'aa' => 2, 'aaa' => 3])
        ->to(p_first(static fn (int $x, string $k) => strlen($k) > 1))
        ->to(shouldBe(2));

        shouldThrow(OutOfBoundsException::class)(
            static fn () =>
            pipe(['a' => 1, 'aa' => 2, 'aaa' => 3])
            ->to(p_first(static fn (int $x, string $k) => strlen($k) > 3))
        );
    }

    public function test_p_first_with_iterables(): void
    {
        shouldThrow(OutOfBoundsException::class)(
            static fn () =>
            pipe(new ArrayIterator([]))
            ->to(p_first())
        );

        shouldThrow(OutOfBoundsException::class)(
            static fn () =>
            pipe(new ArrayIterator([]))
            ->to(p_first(static fn (int $x) => $x > 1))
        );

        pipe(new ArrayIterator([1,2,3]))
        ->to(p_first())
        ->to(shouldBe(1));

        pipe(new ArrayIterator([1,2,3]))
        ->to(p_first(static fn (int $x) => $x > 1))
        ->to(shouldBe(2));

        shouldThrow(OutOfBoundsException::class)(
            static fn () =>
            pipe(new ArrayIterator([1,2,3]))
            ->to(p_first(static fn (int $x) => $x > 3))
        );

        pipe(new ArrayIterator(['a' => 1, 'aa' => 2, 'aaa' => 3]))
        ->to(p_first())
        ->to(shouldBe(1));

        pipe(new ArrayIterator(['a' => 1, 'aa' => 2, 'aaa' => 3]))
        ->to(p_first(static fn (int $x, string $k) => strlen($k) > 1))
        ->to(shouldBe(2));

        shouldThrow(OutOfBoundsException::class)(
            static fn () =>
            pipe(new ArrayIterator(['a' => 1, 'aa' => 2, 'aaa' => 3]))
            ->to(p_first(static fn (int $x, string $k) => strlen($k) > 3))
        );
    }
}
