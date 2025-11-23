<?php

declare(strict_types=1);

namespace ImpartialPipes\Tests\Util;

use ArrayIterator;
use ImpartialPipes\LazyRewindableIterator;
use ImpartialPipes\Tests\SimpleIterator;
use ImpartialPipes\Tests\SimpleIteratorAggregate;
use ImpartialPipes\Tests\UniterableArrayIterator;
use PHPUnit\Framework\TestCase;
use PHPUnitMetaConstraints\Util\PHPUnitMetaConstraintsTrait;

/**
 * @internal
 */
final class LazyRewindableIteratorTest extends TestCase
{
    use PHPUnitMetaConstraintsTrait;

    public function test_rewindable_iterator(): void
    {
        $it = new LazyRewindableIterator(static function () { yield from [1, 2]; });

        $it->valid() |> self::is(true);
        $it->key() |> self::is(0);
        $it->current() |> self::is(1);
        $it->next();
        $it->valid() |> self::is(true);
        $it->key() |> self::is(1);
        $it->current() |> self::is(2);
        $it->rewind();
        $it->valid() |> self::is(true);
        $it->key() |> self::is(0);
        $it->current() |> self::is(1);
        $it->rewind();
        $it->valid() |> self::is(true);
        $it->key() |> self::is(0);
        $it->current() |> self::is(1);
        $it->next();
        $it->valid() |> self::is(true);
        $it->key() |> self::is(1);
        $it->current() |> self::is(2);
        $it->next();
        $it->valid() |> self::is(false);
        $it->key() |> self::is(null);
        $it->current() |> self::is(null);
        $it->rewind();
        $it->valid() |> self::is(true);
        $it->key() |> self::is(0);
        $it->current() |> self::is(1);
    }

    public function test_rewinds(): void
    {
        $it = new LazyRewindableIterator(static fn () => [1,2,3]);
        iterator_to_array($it);
        iterator_to_array($it);
        iterator_to_array($it) |> self::is([1,2,3]);

        $it = new LazyRewindableIterator(static fn () => new ArrayIterator([1,2,3]));
        iterator_to_array($it);
        iterator_to_array($it);
        iterator_to_array($it) |> self::is([1,2,3]);

        $it = new LazyRewindableIterator(static function () { yield from [1, 2, 3]; });
        iterator_to_array($it);
        iterator_to_array($it);
        iterator_to_array($it) |> self::is([1,2,3]);
    }

    public function test_init(): void
    {
        // test calling rewind() right away
        $it = new LazyRewindableIterator(static function () { yield from [1, 2]; });
        $it->rewind();
        $it->key() |> self::is(0);

        // test calling next() right away
        $it = new LazyRewindableIterator(static function () { yield from [1, 2]; });
        $it->next();
        $it->key() |> self::is(1);

        // test calling valid() right away
        $it = new LazyRewindableIterator(static function () { yield from [1, 2]; });
        $it->valid() |> self::is(true);

        // test calling key() right away
        $it = new LazyRewindableIterator(static function () { yield from [1, 2]; });
        $it->key() |> self::is(0);

        // test calling current() right away
        $it = new LazyRewindableIterator(static function () { yield from [1, 2]; });
        $it->current() |> self::is(1);
    }

    public function test_counting_with_countables(): void
    {
        new LazyRewindableIterator(static fn () => [1,2,3])->count()
        |> self::is(3);

        new LazyRewindableIterator(static fn () => new SimpleIterator([1]))->count()
        |> self::is(1);

        new LazyRewindableIterator(static fn () => new UniterableArrayIterator([1,2]))->count()
        |> self::is(2);

        new LazyRewindableIterator(static fn () => new SimpleIteratorAggregate(new SimpleIterator([1,2,3])))->count()
        |> self::is(3);

        new LazyRewindableIterator(static fn () => new SimpleIteratorAggregate(new UniterableArrayIterator([1,2,3,4])))->count()
        |> self::is(4);
    }
}
