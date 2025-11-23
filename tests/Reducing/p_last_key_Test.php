<?php

declare(strict_types=1);

namespace ImpartialPipes\Tests\Reducing;

use ArrayIterator;
use OutOfBoundsException;
use PHPUnit\Framework\TestCase;
use PHPUnitMetaConstraints\Util\PHPUnitMetaConstraintsTrait;

use function ImpartialPipes\p_last_key;

/**
 * @internal
 */
final class p_last_key_Test extends TestCase
{
    use PHPUnitMetaConstraintsTrait;

    public function test_p_last_key_with_arrays(): void
    {
        self::throws(OutOfBoundsException::class)(
            static fn () =>
            [] |> p_last_key()
        );

        self::throws(OutOfBoundsException::class)(
            static fn () =>
            [] |> p_last_key(static fn (int $x) => $x < 3)
        );

        [1,2,3]
        |> p_last_key()
        |> self::is(2);

        [1,2,3]
        |> p_last_key(static fn (int $x) => $x < 3)
        |> self::is(1);

        self::throws(OutOfBoundsException::class)(
            static fn () =>
            [1,2,3] |> p_last_key(static fn (int $x) => $x > 3)
        );

        ['a' => 1, 'aa' => 2, 'aaa' => 3]
        |> p_last_key()
        |> self::is('aaa');

        ['a' => 1, 'aa' => 2, 'aaa' => 3]
        |> p_last_key(static fn (int $x, string $k) => strlen($k) < 3)
        |> self::is('aa');

        self::throws(OutOfBoundsException::class)(
            static fn () =>
            ['a' => 1, 'aa' => 2, 'aaa' => 3]
            |> p_last_key(static fn (int $x, string $k) => strlen($k) > 3)
        );
    }

    public function test_p_last_key_with_iterables(): void
    {
        self::throws(OutOfBoundsException::class)(
            static fn () =>
            new ArrayIterator([])
            |> p_last_key()
        );

        self::throws(OutOfBoundsException::class)(
            static fn () =>
            new ArrayIterator([])
            |> p_last_key(static fn (int $x) => $x < 3)
        );

        new ArrayIterator([1,2,3])
        |> p_last_key()
        |> self::is(2);

        new ArrayIterator([1,2,3])
        |> p_last_key(static fn (int $x) => $x < 3)
        |> self::is(1);

        self::throws(OutOfBoundsException::class)(
            static fn () =>
            new ArrayIterator([1,2,3])
            |> p_last_key(static fn (int $x) => $x > 3)
        );

        new ArrayIterator(['a' => 1, 'aa' => 2, 'aaa' => 3])
        |> p_last_key()
        |> self::is('aaa');

        new ArrayIterator(['a' => 1, 'aa' => 2, 'aaa' => 3])
        |> p_last_key(static fn (int $x, string $k) => strlen($k) < 3)
        |> self::is('aa');

        self::throws(OutOfBoundsException::class)(
            static fn () =>
            new ArrayIterator(['a' => 1, 'aa' => 2, 'aaa' => 3])
            |> p_last_key(static fn (int $x, string $k) => strlen($k) > 3)
        );
    }
}
