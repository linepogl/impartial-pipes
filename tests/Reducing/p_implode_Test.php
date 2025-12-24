<?php

declare(strict_types=1);

namespace ImpartialPipes\Tests\Reducing;

use ImpartialPipes\Tests\SimpleIterator;
use ImpartialPipes\Tests\UniterableArrayIterator;
use PHPUnit\Framework\TestCase;
use PHPUnitMetaConstraints\Util\PHPUnitMetaConstraintsTrait;

use function ImpartialPipes\p_implode;

/**
 * @internal
 */
final class p_implode_Test extends TestCase
{
    use PHPUnitMetaConstraintsTrait;

    public function test_p_implode_with_arrays(): void
    {
        []
        |> p_implode()
        |> self::is('');

        []
        |> p_implode('-')
        |> self::is('');

        [1, 2, 3]
        |> p_implode()
        |> self::is('123');

        [1, 2, 3]
        |> p_implode('-')
        |> self::is('1-2-3');

        [1, 'a', 3.3, null]
        |> p_implode()
        |> self::is('1a3.3');

        [1, 'a', 3.3, null]
        |> p_implode('-')
        |> self::is('1-a-3.3-');
    }

    public function test_p_implode_with_array_iterators(): void
    {
        new UniterableArrayIterator([])
        |> p_implode()
        |> self::is('');

        new UniterableArrayIterator([])
        |> p_implode('-')
        |> self::is('');

        new UniterableArrayIterator([1, 2, 3])
        |> p_implode()
        |> self::is('123');

        new UniterableArrayIterator([1, 2, 3])
        |> p_implode('-')
        |> self::is('1-2-3');

        new UniterableArrayIterator([1, 'a', 3.3, null])
        |> p_implode()
        |> self::is('1a3.3');

        new UniterableArrayIterator([1, 'a', 3.3, null])
        |> p_implode('-')
        |> self::is('1-a-3.3-');
    }

    public function test_p_implode_with_simple_iterators(): void
    {
        new SimpleIterator([])
        |> p_implode()
        |> self::is('');

        new SimpleIterator([])
        |> p_implode('-')
        |> self::is('');

        new SimpleIterator([1, 2, 3])
        |> p_implode()
        |> self::is('123');

        new SimpleIterator([1, 2, 3])
        |> p_implode('-')
        |> self::is('1-2-3');

        new SimpleIterator([1, 'a', 3.3, null])
        |> p_implode()
        |> self::is('1a3.3');

        new SimpleIterator([1, 'a', 3.3, null])
        |> p_implode('-')
        |> self::is('1-a-3.3-');
    }
}
