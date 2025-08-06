# Pipes

A library with partial functions suitable for the pipe operator.

## 1. Mapping partial functions

### it_map

```php
['a' => 1, 'b' => 2] 
|> it_map(static fn (int $value) => $value * $value)
// ['a' => 1, 'b' => 4]
```
```php
['a' => 1, 'b' => 2] 
|> it_map(static fn (int $value, string $key) => $key . $value)
// ['a' => 'a1', 'b' => 'b2']
```

### it_flat_map

```php
['a' => 1, 'b' => 2]
|> it_flat_map(static fn (int $value, string $key) => [$key, $value])
// ['a', 1, 'b', 2]
```

### it_reindex

```php
['a' => 1, 'b' => 2]
|> it_reindex(static fn (int $value, string $key) => $key . $value)
// ['a1' => 1, 'b2' => 2]
```

### it_values
```php
['a' => 1, 'b' => 2]
|> it_values()
// [1, 2]
```

### it_keys
```php
['a' => 1, 'b' => 2]
|> it_keys()
// ['a', 'b']
```

### it_order_by, it_then_by
```php
['a' => 1, 'b' => 2, 'c' => 2, 'd' => 2]
|> it_order_by(static fn (int $value) => $value)
|> it_then_by(static fn (int $value, string $key) => $key, descending: true)
// ['a' => 1, 'd' => 2, 'c' => 2, 'd' => 2]
```

### it_group_by
```php
['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]
|> it_group_by(static fn (int $value) => $value % 2, preserveKeys: false)
// [1 => [1, 3], 0 => [2, 4]]
```
```php
['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]
|> it_group_by(static fn (int $value) => $value % 2, preserveKeys: true)
// [1 => ['a' => 1, 'c' => 3], 0 => ['b' => 2, 'd' => 4]]
```

## 2. Filtering partial functions

### it_filter
```php
['a' => 1, 'b' => 2]
|> it_filter(static fn (int $value) => $value > 1, preserveKeys: true)
// ['b' => 2]
```
```php
['a' => 1, 'b' => 2]
|> it_filter(static fn (int $value) => $value > 1, preserveKeys: false)
// [2]
```
```php
['a' => 1, 'b' => 2]
|> it_filter(static fn (int $value, string $key) => $key === 'b', preserveKeys: true)
// ['b' => 2]
```
```php
['a' => 1, 'b' => 2]
|> it_filter(static fn (int $value, string $key) => $key === 'b', preserveKeys: false)
// [2]
```
### it_compact
```php
['a' => null, 'b' => 2]
|> it_compact(preserveKeys: true)
// ['b' => 2]
```
```php
['a' => null, 'b' => 2]
|> it_compact(preserveKeys: false)
// [2]
```

### it_take
```php
['a' => 1, 'b' => 2, 'c' => 3]
|> it_take(2, preserveKeys: true)
// ['a' => 1, 'b' => 2]
```
```php
['a' => 1, 'b' => 2, 'c' => 3]
|> it_take(preserveKeys: false)
// [1, 2]
```
### it_take_while

```php
['a' => 1, 'b' => 2, 'c' => 3, 'd' => 1]
|> it_take_while(static fn (int $value) => $value < 3, preserveKeys: true)
// ['a' => 1, 'b' => 2]
```
```php
['a' => 1, 'b' => 2, 'c' => 3, 'd' => 1]
|> it_take_while(static fn (int $value) => $value < 3, preserveKeys: false)
// [1, 2]
```
```php
['a' => 1, 'b' => 2]
|> it_filter(static fn (int $value, string $key) => $key === 'a', preserveKeys: true)
// ['a' => 1]
```
```php
['a' => 1, 'b' => 2]
|> it_filter(static fn (int $value, string $key) => $key === 'a', preserveKeys: false)
// [1]
```

### it_skip
```php
['a' => 1, 'b' => 2, 'c' => 3]
|> it_skip(1, preserveKeys: true)
// ['b' => 2, 'c' => 3]
```
```php
['a' => 1, 'b' => 2, 'c' => 3]
|> it_skip(1, preserveKeys: false)
// [2, 3]
```

### it_skip_while

```php
['a' => 1, 'b' => 2, 'c' => 3, 'd' => 1]
|> it_take_while(static fn (int $value) => $value < 3, preserveKeys: true)
// ['a' => 1, 'b' => 2]
```
```php
['a' => 1, 'b' => 2, 'c' => 3, 'd' => 1]
|> it_take_while(static fn (int $value) => $value < 3, preserveKeys: false)
// [1, 2]
```
```php
['a' => 1, 'b' => 2]
|> it_filter(static fn (int $value, string $key) => $key === 'a', preserveKeys: true)
// ['a' => 1]
```
```php
['a' => 1, 'b' => 2]
|> it_filter(static fn (int $value, string $key) => $key === 'a', preserveKeys: false)
// [1]
```

### it_unique
```php
['a' => 1, 'b' => 1, 'c' => 2]
|> it_unique(identity, preserveKeys: true)
// ['a' => 1, 'c' => 2]
```
```php
['a' => 1, 'b' => 1, 'c' => 2]
|> it_unique(identity, preserveKeys: false)
// [1, 2]
```
```php
['a' => 1, 'b' => 2, 'c' => 3, 'd' => 20]
|> it_unique(function (int $value1) => intval($value1 / 10), preserveKeys: true)
// ['a' => 1, 'd' => 20]
```
```php
['a' => 1, 'b' => 1, 'c' => 2, 'd' => 20]
|> it_unique(function (int $value1) => intval($value1 / 10), preserveKeys: false)
// [1, 20]
```
```php
['a' => 1, 'b' => 2, 'c' => 3, 'd' => 20]
|> it_unique(function (int $value1, string $key) => $key, preserveKeys: true)
// ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 20]
```
```php
['a' => 1, 'b' => 1, 'c' => 2, 'd' => 20]
|> it_unique(function (int $value1, string $key) => $key, preserveKeys: false)
// ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 20]
```

## 3. Reducing partial functions

### it_any
```php
['a' => 1, 'b' => 2]
|> it_any(static function (int $value) => $value > 3)
// false
```
```php
['a' => 1, 'b' => 2]
|> it_any(static function (int $value, string $key) => $key === 'a')
// true
```
### it_all
```php
['a' => 1, 'b' => 2]
|> it_all(static function (int $value) => $value > 0)
// true
```
```php
['a' => 1, 'b' => 2]
|> it_all(static function (int $value, string $key) => $key === 'a')
// false
```
### it_sum
```php
['a' => 1, 'b' => 2]
|> it_sum()
// 3
```
### it_implode
```php
['a' => 1, 'b' => 2]
|> it_implode(separator: '-')
// '1-2'
```

## 4. Combining partial functions

### it_union
```php
['a' => 1, 'b' => 2]
|> it_union(['c' => 3, 'd' => 4])
// ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]]
```
