<?php

declare(strict_types=1);

namespace Tests\Filtering;

use PHPUnit\Framework\TestCase;
use PHPUnitMetaConstraints\Util\PHPUnitMetaConstraintsTrait;
use Tests\ConcatIterator;

use function ImpartialPipes\p_unique_keys;
use function ImpartialPipes\pipe;

/**
 * @internal
 */
final class p_unique_keys_Test extends TestCase
{
    use PHPUnitMetaConstraintsTrait;

    public function test_p_unique_keys(): void
    {
        pipe([])
        ->to(p_unique_keys())
        ->to(self::iteratesLike([], rewind: true));

        pipe([])
        ->to(p_unique_keys(preserveKeys: true))
        ->to(self::iteratesLike([], rewind: true));

        pipe(new ConcatIterator(['a' => 1], ['a' => 2], ['b' => 3], ['b' => 4]))
        ->to(p_unique_keys())
        ->to(self::iteratesLike([1, 3], rewind: true));

        pipe(new ConcatIterator(['a' => 1], ['a' => 2], ['b' => 3], ['b' => 4]))
        ->to(p_unique_keys(preserveKeys: true))
        ->to(self::iteratesLike(['a' => 1, 'b' => 3], rewind: true));

        pipe(['a' => 1, 'b' => 2, 'cc' => 3, 'dd' => 4])
        ->to(p_unique_keys(static fn (string $k) => strlen($k)))
        ->to(self::iteratesLike([1, 3], rewind: true));

        pipe(['a' => 1, 'b' => 2, 'cc' => 3, 'dd' => 4])
        ->to(p_unique_keys(static fn (string $k) => strlen($k), preserveKeys: true))
        ->to(self::iteratesLike(['a' => 1, 'cc' => 3], rewind: true));
    }
}
