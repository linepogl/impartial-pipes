<?php

declare(strict_types=1);

namespace ImpartialPipes\Tests\Reducing;

use ArrayIterator;
use PHPUnit\Framework\TestCase;
use PHPUnitMetaConstraints\Util\PHPUnitMetaConstraintsTrait;

use function ImpartialPipes\p_first_or;
use function ImpartialPipes\pipe;

/**
 * @internal
 */
final class p_first_or_Test extends TestCase
{
    use PHPUnitMetaConstraintsTrait;

    public function test_p_first_or_with_arrays(): void
    {
        pipe([])
        ->to(p_first_or(null))
        ->to(self::is(null));

        pipe([])
        ->to(p_first_or(null, static fn (int $x) => $x > 1))
        ->to(self::is(null));

        pipe([1,2,3])
        ->to(p_first_or(null))
        ->to(self::is(1));

        pipe([1,2,3])
        ->to(p_first_or(null, static fn (int $x) => $x > 1))
        ->to(self::is(2));

        pipe([1,2,3])
        ->to(p_first_or(null, static fn (int $x) => $x > 3))
        ->to(self::is(null));

        pipe(['a' => 1, 'aa' => 2, 'aaa' => 3])
        ->to(p_first_or(null))
        ->to(self::is(1));

        pipe(['a' => 1, 'aa' => 2, 'aaa' => 3])
        ->to(p_first_or(null, static fn (int $x, string $k) => strlen($k) > 1))
        ->to(self::is(2));

        pipe(['a' => 1, 'aa' => 2, 'aaa' => 3])
        ->to(p_first_or(null, static fn (int $x, string $k) => strlen($k) > 3))
        ->to(self::is(null));
    }

    public function test_p_first_or_with_iterables(): void
    {
        pipe(new ArrayIterator([]))
        ->to(p_first_or(null))
        ->to(self::is(null));

        pipe(new ArrayIterator([]))
        ->to(p_first_or(null, static fn (int $x) => $x > 1))
        ->to(self::is(null));

        pipe(new ArrayIterator([1,2,3]))
        ->to(p_first_or(null))
        ->to(self::is(1));

        pipe(new ArrayIterator([1,2,3]))
        ->to(p_first_or(null, static fn (int $x) => $x > 1))
        ->to(self::is(2));

        pipe(new ArrayIterator([1,2,3]))
        ->to(p_first_or(null, static fn (int $x) => $x > 3))
        ->to(self::is(null));

        pipe(new ArrayIterator(['a' => 1, 'aa' => 2, 'aaa' => 3]))
        ->to(p_first_or(null))
        ->to(self::is(1));

        pipe(new ArrayIterator(['a' => 1, 'aa' => 2, 'aaa' => 3]))
        ->to(p_first_or(null, static fn (int $x, string $k) => strlen($k) > 1))
        ->to(self::is(2));

        pipe(new ArrayIterator(['a' => 1, 'aa' => 2, 'aaa' => 3]))
        ->to(p_first_or(null, static fn (int $x, string $k) => strlen($k) > 3))
        ->to(self::is(null));
    }
}
