<?php

declare(strict_types=1);

namespace ImpartialPipes\Tests\Reducing;

use ArrayIterator;
use ImpartialPipes\Tests\SimpleIterator;
use ImpartialPipes\Tests\UniterableArrayIterator;
use PHPUnit\Framework\TestCase;
use PHPUnitMetaConstraints\Util\PHPUnitMetaConstraintsTrait;

use function ImpartialPipes\p_any;
use function ImpartialPipes\pipe;

/**
 * @internal
 */
final class p_any_Test extends TestCase
{
    use PHPUnitMetaConstraintsTrait;

    public function test_p_any_with_arrays(): void
    {
        pipe([])
        ->to(p_any(static fn (int $x) => $x % 2 === 1))
        ->to(self::is(false));

        pipe([])
        ->to(p_any(static fn (int $x, string $k) => $k[0] === 'a'))
        ->to(self::is(false));

        pipe([2, 3, 4])
        ->to(p_any(static fn (int $x) => $x % 2 === 1))
        ->to(self::is(true));

        pipe([2, 4, 6])
        ->to(p_any(static fn (int $x) => $x % 2 === 1))
        ->to(self::is(false));

        pipe(['aa' => 1, 'bb' => 2, 'cc' => 3])
        ->to(p_any(static fn (int $x, string $k) => $k[0] === 'b'))
        ->to(self::is(true));

        pipe(['aa' => 1, 'bb' => 2, 'cc' => 3])
        ->to(p_any(static fn (int $x, string $k) => $k[0] === 'd'))
        ->to(self::is(false));
    }

    public function test_p_any_with_iterators(): void
    {
        pipe(new ArrayIterator([]))
        ->to(p_any(static fn (int $x) => $x % 2 === 1))
        ->to(self::is(false));

        pipe(new ArrayIterator([]))
        ->to(p_any(static fn (int $x, string $k) => $k[0] === 'a'))
        ->to(self::is(false));

        pipe(new ArrayIterator([2, 3, 4]))
        ->to(p_any(static fn (int $x) => $x % 2 === 1))
        ->to(self::is(true));

        pipe(new ArrayIterator([2, 4, 6]))
        ->to(p_any(static fn (int $x) => $x % 2 === 1))
        ->to(self::is(false));

        pipe(new ArrayIterator(['aa' => 1, 'bb' => 2, 'cc' => 3]))
        ->to(p_any(static fn (int $x, string $k) => $k[0] === 'b'))
        ->to(self::is(true));

        pipe(new ArrayIterator(['aa' => 1, 'bb' => 2, 'cc' => 3]))
        ->to(p_any(static fn (int $x, string $k) => $k[0] === 'd'))
        ->to(self::is(false));
    }

    public function test_p_any_without_a_predicate(): void
    {
        pipe([])
        ->to(p_any())
        ->to(self::is(false));

        pipe([1, 2])
        ->to(p_any())
        ->to(self::is(true));

        pipe(new UniterableArrayIterator([]))
        ->to(p_any())
        ->to(self::is(false));

        pipe(new UniterableArrayIterator([1, 2]))
        ->to(p_any())
        ->to(self::is(true));

        pipe(new SimpleIterator([]))
        ->to(p_any())
        ->to(self::is(false));

        pipe(new SimpleIterator([1, 2]))
        ->to(p_any())
        ->to(self::is(true));
    }
}
