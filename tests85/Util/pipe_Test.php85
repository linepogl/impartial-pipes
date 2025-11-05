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
        self::is('123')(pipe(123)->to(strval(...))->value);
    }

    public function test_pipe_invokable(): void
    {
        self::is('123')(pipe(123)(strval(...))());
    }
}
