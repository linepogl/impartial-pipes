<?php

declare(strict_types=1);

namespace ImpartialPipes;

/**
 * @return callable<K,V>(iterable<K, V>):int
 */
function p_count(): callable
{
    return iterator_count(...);
}
