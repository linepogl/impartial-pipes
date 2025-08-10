<?php

declare(strict_types=1);

namespace Tests\Reducing;

use ArrayIterator;
use OutOfBoundsException;
use PHPUnit\Framework\TestCase;

use function ImpartialPipes\p_last;
use function ImpartialPipes\pipe;
use function Tests\shouldBe;
use function Tests\shouldThrow;

/**
 * @internal
 */
final class p_last_Test extends TestCase
{
    public function test_p_last_with_arrays(): void
    {
        shouldThrow(OutOfBoundsException::class)(
            static fn () =>
            pipe([])
            ->to(p_last())
        );

        shouldThrow(OutOfBoundsException::class)(
            static fn () =>
            pipe([])
            ->to(p_last(static fn (int $x) => $x < 3))
        );

        pipe([1,2,3])
        ->to(p_last())
        ->to(shouldBe(3));

        pipe([1,2,3])
        ->to(p_last(static fn (int $x) => $x < 3))
        ->to(shouldBe(2));

        shouldThrow(OutOfBoundsException::class)(
            static fn () =>
            pipe([1,2,3])
            ->to(p_last(static fn (int $x) => $x > 3))
        );

        pipe(['a' => 1, 'aa' => 2, 'aaa' => 3])
        ->to(p_last())
        ->to(shouldBe(3));

        pipe(['a' => 1, 'aa' => 2, 'aaa' => 3])
        ->to(p_last(static fn (int $x, string $k) => strlen($k) < 3))
        ->to(shouldBe(2));

        shouldThrow(OutOfBoundsException::class)(
            static fn () =>
            pipe(['a' => 1, 'aa' => 2, 'aaa' => 3])
            ->to(p_last(static fn (int $x, string $k) => strlen($k) > 3))
        );
    }

    public function test_p_last_with_iterables(): void
    {
        shouldThrow(OutOfBoundsException::class)(
            static fn () =>
            pipe(new ArrayIterator([]))
            ->to(p_last())
        );

        shouldThrow(OutOfBoundsException::class)(
            static fn () =>
            pipe(new ArrayIterator([]))
            ->to(p_last(static fn (int $x) => $x < 3))
        );

        pipe(new ArrayIterator([1,2,3]))
        ->to(p_last())
        ->to(shouldBe(3));

        pipe(new ArrayIterator([1,2,3]))
        ->to(p_last(static fn (int $x) => $x < 3))
        ->to(shouldBe(2));

        shouldThrow(OutOfBoundsException::class)(
            static fn () =>
            pipe(new ArrayIterator([1,2,3]))
            ->to(p_last(static fn (int $x) => $x > 3))
        );

        pipe(new ArrayIterator(['a' => 1, 'aa' => 2, 'aaa' => 3]))
        ->to(p_last())
        ->to(shouldBe(3));

        pipe(new ArrayIterator(['a' => 1, 'aa' => 2, 'aaa' => 3]))
        ->to(p_last(static fn (int $x, string $k) => strlen($k) < 3))
        ->to(shouldBe(2));

        shouldThrow(OutOfBoundsException::class)(
            static fn () =>
            pipe(new ArrayIterator(['a' => 1, 'aa' => 2, 'aaa' => 3]))
            ->to(p_last(static fn (int $x, string $k) => strlen($k) > 3))
        );
    }
}
