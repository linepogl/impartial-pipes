<?php

declare(strict_types=1);

namespace Pipes;

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

const identity = __NAMESPACE__ . '\identity'; // this is a callable constant
