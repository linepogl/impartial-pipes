# Impartial Pipes

A PHP library providing partial functions suitable for the pipe operator.

```
$iterable
 |> p_skip(5)
 |> p_take(10)
 |> p_unique()
 |> p_map(static fn (int $x) => $x + 1)
 |> p_filter(static fn (int $x) => $x % 2 === 0)
 |> p_sum()
```

### Why use it?

1. Consistent interface: always one argument expected to be passed by the pipe operator.
2. Consistent interface: always fn($value,$key).
3. Type checking with phpstan and generics.
4. Immutability, lazy evaluation.
5. Iterating with generators, without creating copies of the data.

# Usage

## 1. Mapping

### p_map

```php
['a' => 1, 'b' => 2] 
|> p_map(static fn (int $value) => $value * $value)
// ['a' => 1, 'b' => 4]
```
```php
['a' => 1, 'b' => 2] 
|> p_map(static fn (int $value, string $key) => $key . $value)
// ['a' => 'a1', 'b' => 'b2']
```

### p_flat_map

```php
['a' => 1, 'b' => 2]
|> p_flat_map(static fn (int $value, string $key) => [$key, $value])
// ['a', 1, 'b', 2]
```

### p_reindex

```php
['a' => 1, 'b' => 2]
|> p_reindex(static fn (int $value, string $key) => $key . $value)
// ['a1' => 1, 'b2' => 2]
```

### p_values
```php
['a' => 1, 'b' => 2]
|> p_values()
// [1, 2]
```

### p_keys
```php
['a' => 1, 'b' => 2]
|> p_keys()
// ['a', 'b']
```

### p_order_by, p_then_by
```php
['a' => 1, 'b' => 2, 'c' => 2, 'd' => 2]
|> p_order_by(static fn (int $value) => $value)
|> p_then_by(static fn (int $value, string $key) => $key, descending: true)
// ['a' => 1, 'd' => 2, 'c' => 2, 'd' => 2]
```

### p_group_by
```php
['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]
|> p_group_by(static fn (int $value) => $value % 2)
// [1 => [1, 3], 0 => [2, 4]]
```
```php
['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]
|> p_group_by(static fn (int $value) => $value % 2, preserveKeys: true)
// [1 => ['a' => 1, 'c' => 3], 0 => ['b' => 2, 'd' => 4]]
```

## 2. Filtering

### p_filter
```php
['a' => 1, 'b' => 2]
|> p_filter(static fn (int $value) => $value > 1, preserveKeys: true)
// ['b' => 2]
```
```php
['a' => 1, 'b' => 2]
|> p_filter(static fn (int $value) => $value > 1)
// [2]
```
```php
['a' => 1, 'b' => 2]
|> p_filter(static fn (int $value, string $key) => $key === 'b', preserveKeys: true)
// ['b' => 2]
```
```php
['a' => 1, 'b' => 2]
|> p_filter(static fn (int $value, string $key) => $key === 'b')
// [2]
```
### p_compact
```php
['a' => null, 'b' => 2]
|> p_compact(preserveKeys: true)
// ['b' => 2]
```
```php
['a' => null, 'b' => 2]
|> p_compact()
// [2]
```

### p_take
```php
['a' => 1, 'b' => 2, 'c' => 3]
|> p_take(2, preserveKeys: true)
// ['a' => 1, 'b' => 2]
```
```php
['a' => 1, 'b' => 2, 'c' => 3]
|> p_take()
// [1, 2]
```
### p_take_while

```php
['a' => 1, 'b' => 2, 'c' => 3, 'd' => 1]
|> p_take_while(static fn (int $value) => $value < 3, preserveKeys: true)
// ['a' => 1, 'b' => 2]
```
```php
['a' => 1, 'b' => 2, 'c' => 3, 'd' => 1]
|> p_take_while(static fn (int $value) => $value < 3)
// [1, 2]
```
```php
['a' => 1, 'b' => 2]
|> p_filter(static fn (int $value, string $key) => $key === 'a', preserveKeys: true)
// ['a' => 1]
```
```php
['a' => 1, 'b' => 2]
|> p_filter(static fn (int $value, string $key) => $key === 'a')
// [1]
```

### p_skip
```php
['a' => 1, 'b' => 2, 'c' => 3]
|> p_skip(1, preserveKeys: true)
// ['b' => 2, 'c' => 3]
```
```php
['a' => 1, 'b' => 2, 'c' => 3]
|> p_skip(1)
// [2, 3]
```

### p_skip_while

```php
['a' => 1, 'b' => 2, 'c' => 3, 'd' => 1]
|> p_take_while(static fn (int $value) => $value < 3, preserveKeys: true)
// ['a' => 1, 'b' => 2]
```
```php
['a' => 1, 'b' => 2, 'c' => 3, 'd' => 1]
|> p_take_while(static fn (int $value) => $value < 3)
// [1, 2]
```
```php
['a' => 1, 'b' => 2]
|> p_filter(static fn (int $value, string $key) => $key === 'a', preserveKeys: true)
// ['a' => 1]
```
```php
['a' => 1, 'b' => 2]
|> p_filter(static fn (int $value, string $key) => $key === 'a')
// [1]
```

### p_unique
```php
['a' => 1, 'b' => 1, 'c' => 2]
|> p_unique(identity, preserveKeys: true)
// ['a' => 1, 'c' => 2]
```
```php
['a' => 1, 'b' => 1, 'c' => 2]
|> p_unique(identity)
// [1, 2]
```
```php
['a' => 1, 'b' => 2, 'c' => 3, 'd' => 20]
|> p_unique(function (int $value1) => intval($value1 / 10), preserveKeys: true)
// ['a' => 1, 'd' => 20]
```
```php
['a' => 1, 'b' => 1, 'c' => 2, 'd' => 20]
|> p_unique(function (int $value1) => intval($value1 / 10))
// [1, 20]
```
```php
['a' => 1, 'b' => 2, 'c' => 3, 'd' => 20]
|> p_unique(function (int $value1, string $key) => $key, preserveKeys: true)
// ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 20]
```
```php
['a' => 1, 'b' => 1, 'c' => 2, 'd' => 20]
|> p_unique(function (int $value1, string $key) => $key)
// ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 20]
```

## 3. Reducing

### p_any
```php
['a' => 1, 'b' => 2]
|> p_any(static function (int $value) => $value > 3)
// false
```
```php
['a' => 1, 'b' => 2]
|> p_any(static function (int $value, string $key) => $key === 'a')
// true
```
### p_all
```php
['a' => 1, 'b' => 2]
|> p_all(static function (int $value) => $value > 0)
// true
```
```php
['a' => 1, 'b' => 2]
|> p_all(static function (int $value, string $key) => $key === 'a')
// false
```
### p_sum
```php
['a' => 1, 'b' => 2]
|> p_sum()
// 3
```
### p_implode
```php
['a' => 1, 'b' => 2]
|> p_implode(separator: '-')
// '1-2'
```

## 4. Combining

### p_union
```php
['a' => 1, 'b' => 2]
|> p_union(['c' => 3, 'd' => 4])
// ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]]
```
