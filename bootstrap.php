<?php

declare(strict_types=1);

require __DIR__ . '/src/Util/iterable_count.php';
require __DIR__ . '/src/Util/iterable_to_iterator.php';
require __DIR__ . '/src/Util/LazyRewindableIterator.php';

require __DIR__ . '/src/Combining/p_merge.php';

require __DIR__ . '/src/Filtering/p_filter.php';
require __DIR__ . '/src/Filtering/p_filter_out.php';
require __DIR__ . '/src/Filtering/p_filter_out_nulls.php';
require __DIR__ . '/src/Filtering/p_skip.php';
require __DIR__ . '/src/Filtering/p_skip_while.php';
require __DIR__ . '/src/Filtering/p_take.php';
require __DIR__ . '/src/Filtering/p_take_while.php';
require __DIR__ . '/src/Filtering/p_unique.php';

require __DIR__ . '/src/Mapping/p_flat_map.php';
require __DIR__ . '/src/Mapping/p_group_by.php';
require __DIR__ . '/src/Mapping/p_keys.php';
require __DIR__ . '/src/Mapping/p_map.php';
require __DIR__ . '/src/Mapping/p_order_by_then_by.php';
require __DIR__ . '/src/Mapping/p_reindex.php';
require __DIR__ . '/src/Mapping/p_values.php';

require __DIR__ . '/src/Reducing/p_any.php';
require __DIR__ . '/src/Reducing/p_all.php';
require __DIR__ . '/src/Reducing/p_count.php';
require __DIR__ . '/src/Reducing/p_first.php';
require __DIR__ . '/src/Reducing/p_first_key.php';
require __DIR__ . '/src/Reducing/p_first_key_or_null.php';
require __DIR__ . '/src/Reducing/p_first_or_null.php';
require __DIR__ . '/src/Reducing/p_foreach.php';
require __DIR__ . '/src/Reducing/p_implode.php';
require __DIR__ . '/src/Reducing/p_last.php';
require __DIR__ . '/src/Reducing/p_last_key.php';
require __DIR__ . '/src/Reducing/p_last_key_or_null.php';
require __DIR__ . '/src/Reducing/p_last_or_null.php';
require __DIR__ . '/src/Reducing/p_sum.php';
require __DIR__ . '/src/Reducing/p_to_array.php';
