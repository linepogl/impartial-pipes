<?php

declare(strict_types=1);

namespace Tests\Util;

use PHPUnit\Framework\TestCase;

use function ImpartialPipes\pipe;
use function Tests\shouldBe;

/**
 * @internal
 */
final class pipe_Test extends TestCase
{
    public function test_pipe(): void
    {
        shouldBe(123)(pipe(123)->to(strval(...))->value);
    }

    public function test_pipe_invokable(): void
    {
        shouldBe(123)(pipe(123)(strval(...))());
    }
}
