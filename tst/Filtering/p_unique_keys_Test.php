<?php

declare(strict_types=1);

namespace Tests\Filtering;

use ImpartialPipes\LazyRewindableIterator;
use PHPUnit\Framework\TestCase;

use function ImpartialPipes\p_unique_keys;
use function ImpartialPipes\pipe;
use function Should\shouldIterateLike;

/**
 * @internal
 */
final class p_unique_keys_Test extends TestCase
{
    public function test_p_unique_keys(): void
    {
        pipe([])
        ->to(p_unique_keys())
        ->to(shouldIterateLike([], repeatedly: true));

        pipe([])
        ->to(p_unique_keys(preserveKeys: true))
        ->to(shouldIterateLike([], repeatedly: true));

        pipe(new LazyRewindableIterator(static function() { yield 'a' => 1; yield 'a' => 2; yield 'b' => 3; yield 'b' => 4; }))
        ->to(p_unique_keys())
        ->to(shouldIterateLike([1, 3], repeatedly: true));

        pipe(new LazyRewindableIterator(static function() { yield 'a' => 1; yield 'a' => 2; yield 'b' => 3; yield 'b' => 4; }))
        ->to(p_unique_keys(preserveKeys: true))
        ->to(shouldIterateLike(['a' => 1, 'b' => 3], repeatedly: true));

        pipe(['a' => 1, 'b' => 2, 'cc' => 3, 'dd' => 4])
        ->to(p_unique_keys(static fn (string $k) => strlen($k)))
        ->to(shouldIterateLike([1, 3], repeatedly: true));

        pipe(['a' => 1, 'b' => 2, 'cc' => 3, 'dd' => 4])
        ->to(p_unique_keys(static fn (string $k) => strlen($k), preserveKeys: true))
        ->to(shouldIterateLike(['a' => 1, 'cc' => 3], repeatedly: true));
    }
}
