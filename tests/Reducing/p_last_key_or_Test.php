<?php

declare(strict_types=1);

namespace ImpartialPipes\Tests\Reducing;

use ArrayIterator;
use PHPUnit\Framework\TestCase;
use PHPUnitMetaConstraints\Util\PHPUnitMetaConstraintsTrait;

use function ImpartialPipes\p_last_key_or;

/**
 * @internal
 */
final class p_last_key_or_Test extends TestCase
{
    use PHPUnitMetaConstraintsTrait;

    public function test_p_last_key_or_with_arrays(): void
    {
        []
        |> p_last_key_or(null)
        |> self::is(null);

        []
        |> p_last_key_or(null, static fn (int $x) => $x < 3)
        |> self::is(null);

        [1,2,3]
        |> p_last_key_or(null)
        |> self::is(2);

        [1,2,3]
        |> p_last_key_or(null, static fn (int $x) => $x < 3)
        |> self::is(1);

        [1,2,3]
        |> p_last_key_or(null, static fn (int $x) => $x > 3)
        |> self::is(null);

        ['a' => 1, 'aa' => 2, 'aaa' => 3]
        |> p_last_key_or(null)
        |> self::is('aaa');

        ['a' => 1, 'aa' => 2, 'aaa' => 3]
        |> p_last_key_or(null, static fn (int $x, string $k) => strlen($k) < 3)
        |> self::is('aa');

        ['a' => 1, 'aa' => 2, 'aaa' => 3]
        |> p_last_key_or(null, static fn (int $x, string $k) => strlen($k) > 3)
        |> self::is(null);
    }

    public function test_p_last_key_or_with_iterables(): void
    {
        new ArrayIterator([])
        |> p_last_key_or(null)
        |> self::is(null);

        new ArrayIterator([])
        |> p_last_key_or(null, static fn (int $x) => $x < 3)
        |> self::is(null);

        new ArrayIterator([1,2,3])
        |> p_last_key_or(null)
        |> self::is(2);

        new ArrayIterator([1,2,3])
        |> p_last_key_or(null, static fn (int $x) => $x < 3)
        |> self::is(1);

        new ArrayIterator([1,2,3])
        |> p_last_key_or(null, static fn (int $x) => $x > 3)
        |> self::is(null);

        new ArrayIterator(['a' => 1, 'aa' => 2, 'aaa' => 3])
        |> p_last_key_or(null)
        |> self::is('aaa');

        new ArrayIterator(['a' => 1, 'aa' => 2, 'aaa' => 3])
        |> p_last_key_or(null, static fn (int $x, string $k) => strlen($k) < 3)
        |> self::is('aa');

        new ArrayIterator(['a' => 1, 'aa' => 2, 'aaa' => 3])
        |> p_last_key_or(null, static fn (int $x, string $k) => strlen($k) > 3)
        |> self::is(null);
    }
}
