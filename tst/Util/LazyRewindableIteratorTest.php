<?php

declare(strict_types=1);

namespace Tests\Util;

use ImpartialPipes\LazyRewindableIterator;
use RuntimeException;
use Tests\UnitTestCase;

/**
 * @internal
 */
final class LazyRewindableIteratorTest extends UnitTestCase
{
    public function test_rewindable_iterator(): void
    {
        $it = new LazyRewindableIterator(static function () { yield from [1, 2]; });

        $this->expect(fn () => $it->current())->toThrow(RuntimeException::class);
        $this->expect(fn () => $it->key())->toThrow(RuntimeException::class);
        $this->expect(fn () => $it->valid())->toThrow(RuntimeException::class);
        $this->expect(fn () => $it->next())->toThrow(RuntimeException::class);
        $it->rewind();
        $this->expect($it->key())->toBe(0);
        $this->expect($it->current())->toBe(1);
        $this->expect($it->valid())->toBe(true);
        $it->rewind();
        $this->expect($it->key())->toBe(0);
        $this->expect($it->current())->toBe(1);
        $this->expect($it->valid())->toBe(true);
        $it->next();
        $this->expect($it->key())->toBe(1);
        $this->expect($it->current())->toBe(2);
        $this->expect($it->valid())->toBe(true);
        $it->next();
        $this->expect($it->key())->toBe(null);
        $this->expect($it->current())->toBe(null);
        $this->expect($it->valid())->toBe(false);
        $it->rewind();
        $this->expect($it->key())->toBe(0);
        $this->expect($it->current())->toBe(1);
        $this->expect($it->valid())->toBe(true);
    }
}
