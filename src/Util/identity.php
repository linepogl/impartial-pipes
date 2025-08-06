<?php

declare(strict_types=1);

namespace ImpartialPipes;

const identity = __NAMESPACE__ . '\identity';

/**
 * @template T
 *
 * @param T $x
 *
 * return T
 */
function identity(mixed $x): mixed
{
    return $x;
}
