<?php

declare(strict_types=1);

namespace Tests\Reducing;

use ArrayIterator;
use OutOfBoundsException;
use PHPUnit\Framework\TestCase;
use PHPUnitMetaConstraints\Throws;
use PHPUnitMetaConstraints\Util\PhpUnitMetaConstraintsTrait;

use function ImpartialPipes\p_first_key;
use function ImpartialPipes\pipe;

/**
 * @internal
 */
final class p_first_key_Test extends TestCase
{
    use PhpunitMetaConstraintsTrait;

    public function test_p_first_key_with_arrays(): void
    {
        new Throws(OutOfBoundsException::class)(
            static fn () =>
            pipe([])
            ->to(p_first_key())
        );

        new Throws(OutOfBoundsException::class)(
            static fn () =>
            pipe([])
            ->to(p_first_key(static fn (int $x) => $x > 1))
        );

        pipe([1,2,3])
        ->to(p_first_key())
        ->to(self::is(0));

        pipe([1,2,3])
        ->to(p_first_key(static fn (int $x) => $x > 1))
        ->to(self::is(1));

        new Throws(OutOfBoundsException::class)(
            static fn () =>
            pipe([1,2,3])
            ->to(p_first_key(static fn (int $x) => $x > 3))
        );

        pipe(['a' => 1, 'aa' => 2, 'aaa' => 3])
        ->to(p_first_key())
        ->to(self::is('a'));

        pipe(['a' => 1, 'aa' => 2, 'aaa' => 3])
        ->to(p_first_key(static fn (int $x, string $k) => strlen($k) > 1))
        ->to(self::is('aa'));

        new Throws(OutOfBoundsException::class)(
            static fn () =>
            pipe(['a' => 1, 'aa' => 2, 'aaa' => 3])
            ->to(p_first_key(static fn (int $x, string $k) => strlen($k) > 3))
        );
    }

    public function test_p_first_key_with_iterables(): void
    {
        new Throws(OutOfBoundsException::class)(
            static fn () =>
            pipe(new ArrayIterator([]))
            ->to(p_first_key())
        );

        new Throws(OutOfBoundsException::class)(
            static fn () =>
            pipe(new ArrayIterator([]))
            ->to(p_first_key(static fn (int $x) => $x > 1))
        );

        pipe(new ArrayIterator([1,2,3]))
        ->to(p_first_key())
        ->to(self::is(0));

        pipe(new ArrayIterator([1,2,3]))
        ->to(p_first_key(static fn (int $x) => $x > 1))
        ->to(self::is(1));

        new Throws(OutOfBoundsException::class)(
            static fn () =>
            pipe(new ArrayIterator([1,2,3]))
            ->to(p_first_key(static fn (int $x) => $x > 3))
        );

        pipe(new ArrayIterator(['a' => 1, 'aa' => 2, 'aaa' => 3]))
        ->to(p_first_key())
        ->to(self::is('a'));

        pipe(new ArrayIterator(['a' => 1, 'aa' => 2, 'aaa' => 3]))
        ->to(p_first_key(static fn (int $x, string $k) => strlen($k) > 1))
        ->to(self::is('aa'));

        new Throws(OutOfBoundsException::class)(
            static fn () =>
            pipe(new ArrayIterator(['a' => 1, 'aa' => 2, 'aaa' => 3]))
            ->to(p_first_key(static fn (int $x, string $k) => strlen($k) > 3))
        );
    }
}
