<?php

declare(strict_types=1);

require __DIR__ . '/Util/iterable_to_iterator.php';
require __DIR__ . '/Util/identity.php';
require __DIR__ . '/Util/LazyRewindableIterator.php';
require __DIR__ . '/Util/OrderedIterator.php';

require __DIR__ . '/Filtering/it_compact.php';
require __DIR__ . '/Filtering/it_filter.php';
require __DIR__ . '/Filtering/it_skip.php';
require __DIR__ . '/Filtering/it_skip_while.php';
require __DIR__ . '/Filtering/it_take.php';
require __DIR__ . '/Filtering/it_take_while.php';
require __DIR__ . '/Filtering/it_unique.php';

require __DIR__ . '/Mapping/it_flat_map.php';
require __DIR__ . '/Mapping/it_group_by.php';
require __DIR__ . '/Mapping/it_keys.php';
require __DIR__ . '/Mapping/it_map.php';
require __DIR__ . '/Mapping/it_reindex.php';
require __DIR__ . '/Mapping/it_values.php';

require __DIR__ . '/Reducing/it_any.php';
require __DIR__ . '/Reducing/it_all.php';
require __DIR__ . '/Reducing/it_implode.php';
require __DIR__ . '/Reducing/it_sum.php';
