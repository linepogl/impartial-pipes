<?php

declare(strict_types=1);

require __DIR__ . '/Util/iterable_to_iterator.php';
require __DIR__ . '/Util/identity.php';
require __DIR__ . '/Util/LazyRewindableIterator.php';
require __DIR__ . '/Util/OrderedIterator.php';

require __DIR__ . '/Filtering/p_compact.php';
require __DIR__ . '/Filtering/p_filter.php';
require __DIR__ . '/Filtering/p_skip.php';
require __DIR__ . '/Filtering/p_skip_while.php';
require __DIR__ . '/Filtering/p_take.php';
require __DIR__ . '/Filtering/p_take_while.php';
require __DIR__ . '/Filtering/p_unique.php';

require __DIR__ . '/Mapping/p_flat_map.php';
require __DIR__ . '/Mapping/p_group_by.php';
require __DIR__ . '/Mapping/p_keys.php';
require __DIR__ . '/Mapping/p_map.php';
require __DIR__ . '/Mapping/p_reindex.php';
require __DIR__ . '/Mapping/p_values.php';

require __DIR__ . '/Reducing/p_any.php';
require __DIR__ . '/Reducing/p_all.php';
require __DIR__ . '/Reducing/p_implode.php';
require __DIR__ . '/Reducing/p_sum.php';
