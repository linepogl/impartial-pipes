<?php

declare(strict_types=1);

namespace ImpartialPipes\Tests\Util;

use Ds\Hashable;
use InvalidArgumentException;
use LogicException;
use Override;
use PHPUnit\Framework\TestCase;
use PHPUnitMetaConstraints\Util\PHPUnitMetaConstraintsTrait;
use stdClass;

use function ImpartialPipes\as_array_key;

/**
 * @internal
 */
final class as_array_key_Test extends TestCase
{
    use PHPUnitMetaConstraintsTrait;

    public function test_as_array_key(): void
    {
        as_array_key(1) |> self::is(1);
        as_array_key('foo') |> self::is('foo');
        as_array_key('') |> self::is('');
        as_array_key(1.1) |> self::is('1.1');
        as_array_key(1.0) |> self::is('1');
        as_array_key(1.000) |> self::is('1');
        as_array_key(true) |> self::is(1);
        as_array_key(false) |> self::is(0);
        as_array_key(new AsArrayKeyHashable()) |> self::is('hash');

        $obj = new stdClass();
        as_array_key($obj) |> self::is(spl_object_hash($obj));

        self::throws(new InvalidArgumentException('Cannot get a hash for input type: null'))(static fn () => as_array_key(null));
        self::throws(new InvalidArgumentException('Cannot get a hash for input type: array'))(static fn () => as_array_key([]));
    }
}

class AsArrayKeyHashable implements Hashable
{
    #[Override]
    public function hash(): string
    {
        return 'hash';
    }

    #[Override]
    public function equals(mixed $obj): bool
    {
        throw new LogicException('Not implemented');
    }
}
