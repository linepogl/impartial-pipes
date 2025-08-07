<?php

declare(strict_types=1);

namespace ImpartialPipes;

use Countable;

/**
 * @return callable<K,V>(iterable<K, V>|Countable):int<0,max>
 */
function p_count(): callable
{
    return static function (iterable|Countable $input) {
        return $input instanceof Countable
            ? $input->count()
            : iterable_count($input);
    };
}
