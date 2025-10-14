<?php

declare(strict_types=1);

namespace Tests\Reducing;

use ArrayIterator;
use PHPUnit\Framework\TestCase;
use PHPUnitMetaConstraints\Util\PhpUnitMetaConstraintsTrait;

use function ImpartialPipes\p_all;
use function ImpartialPipes\pipe;

/**
 * @internal
 */
final class p_all_Test extends TestCase
{
    use PhpunitMetaConstraintsTrait;

    public function test_p_all_with_arrays(): void
    {
        pipe([])
        ->to(p_all(static fn (int $x) => $x % 2 === 1))
        ->to(self::is(true));

        pipe([])
        ->to(p_all(static fn (int $x, string $k) => $k[0] === 'a'))
        ->to(self::is(true));

        pipe([1, 3, 5])
        ->to(p_all(static fn (int $x) => $x % 2 === 1))
        ->to(self::is(true));

        pipe([1, 2, 5])
        ->to(p_all(static fn (int $x) => $x % 2 === 1))
        ->to(self::is(false));

        pipe(['a' => 1, 'aa' => 2, 'aaa' => 3])
        ->to(p_all(static fn (int $x, string $k) => $k[0] === 'a'))
        ->to(self::is(true));

        pipe(['a' => 1, 'b' => 2, 'c' => 3])
        ->to(p_all(static fn (int $x, string $k) => $k[0] === 'a'))
        ->to(self::is(false));
    }

    public function test_p_all_with_iterators(): void
    {
        pipe(new ArrayIterator([]))
        ->to(p_all(static fn (int $x) => $x % 2 === 1))
        ->to(self::is(true));

        pipe(new ArrayIterator([]))
        ->to(p_all(static fn (int $x, string $k) => $k[0] === 'a'))
        ->to(self::is(true));

        pipe(new ArrayIterator([1, 3, 5]))
        ->to(p_all(static fn (int $x) => $x % 2 === 1))
        ->to(self::is(true));

        pipe(new ArrayIterator([1, 2, 5]))
        ->to(p_all(static fn (int $x) => $x % 2 === 1))
        ->to(self::is(false));

        pipe(new ArrayIterator(['a' => 1, 'aa' => 2, 'aaa' => 3]))
        ->to(p_all(static fn (int $x, string $k) => $k[0] === 'a'))
        ->to(self::is(true));

        pipe(new ArrayIterator(['a' => 1, 'b' => 2, 'c' => 3]))
        ->to(p_all(static fn (int $x, string $k) => $k[0] === 'a'))
        ->to(self::is(false));
    }
}
