# Impartial Pipes

A PHP library providing partial functions suitable for the pipe operator.

```
$iterable
 |> p_skip(5)
 |> p_take(10)
 |> p_unique()
 |> p_filter(static fn (int $x) => $x % 2 === 0)
 |> p_map(static fn (int $x, int $key) => ['key' => $key, 'value' => $x])
 |> p_order_by(static fn (array $x) => $x['value'])
 |> p_implode('-')
```

### Why use it?

The pipe operator of PHP is a great way to chain functions together. However, it is not perfect because it requires that the chained functions accept exactly one mandatory argument. When this is not the case, we have to resort to workarounds by wrapping the functions in a closure.

```php
$array
 |> static fn ($in) => array_map(static fn (int $x) => $x * $x), $in)
 |> static fn ($in) => array_filter($in, static fn (int $x) => $x % 2 === 1))
```

This might be solved in a future version of PHP, with a proposed syntax like this:

```php
$array
 |> array_map(static fn (int $x) => $x * $x), ...)
 |> array_filter(..., static fn (int $x) => $x % 2 === 1))
```

This is a step in the right direction. However, it is still not perfect:
 - We still have to remember the infamously inconsistent order of the arguments.
 - It works only for arrays, but not for iterables, because the standard library offers too few functions for that.

With Impartial Pipes, we can write the same code as this, right off the 8.5 version of PHP:

```php
$iterable
 |> p_map(static fn (int $x) => $x * $x)
 |> p_filter(static fn (int $x) => $x % 2 === 1)
```

### Features

1. Consistent interface: always one argument expected to be passed by the pipe operator.
2. Type checking with phpstan and generics.
3. Immutability and lazy evaluation.
4. Iterating with rewindable generators without creating copies of the data. Fallback to array functions when no copies are involved.
5. 100% test coverage.

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
|> p_flat_map(static fn (int $value) => [$value, $value * $value])
// [1, 1, 2, 4]
```
```php
['a' => 1, 'b' => 2]
|> p_flat_map(static fn (int $value, string $key) => [$key, $value])
// ['a', 1, 'b', 2]
```

### p_reindex

```php
['a' => 1, 'b' => 2]
|> p_reindex(static fn (int $value) => $value * $value)
// [1 => 1, 4 => 2]
```
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

### p_merge
```php
['a' => 1, 'b' => 2]
|> p_merge(['c' => 3, 'd' => 4])
// ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]]
```
