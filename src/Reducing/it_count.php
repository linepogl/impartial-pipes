<?php

declare(strict_types=1);

namespace Pipes;

/**
 * @return callable<K,V>(iterable<K, V>):int
 */
function it_count(): callable
{
    return iterator_count(...);
}
