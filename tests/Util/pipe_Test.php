<?php

declare(strict_types=1);

namespace ImpartialPipes\Tests\Util;

use PHPUnit\Framework\TestCase;
use PHPUnitMetaConstraints\Util\PHPUnitMetaConstraintsTrait;

use function ImpartialPipes\pipe;

/**
 * @internal
 */
final class pipe_Test extends TestCase
{
    use PHPUnitMetaConstraintsTrait;

    public function test_pipe(): void
    {
        pipe(123)->to(strval(...))->value
        |> self::is('123');
    }

    public function test_pipe_invokable(): void
    {
        pipe(123)(strval(...))()
        |> self::is('123');
    }
}
