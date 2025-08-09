# Impartial Pipes

A PHP library providing partial functions suitable for the pipe operator.

```
$users
|> p_filter(static fn (User $user) => $user->isAdmin)
|> p_order_by(static fn (User $x) => $user->age, descending: true)
|> p_then_by(static fn (User $x) => $user->name)
|> p_map(static fn (User $user) => $user->email)
|> p_unique()
|> p_skip(5)
|> p_take(10)
|> p_implode(';')
```

### Features

1. All the produced partial functions have exactly one argument, as the pipe operator expects.
2. Type checking with phpstan and generics.
3. Immutability and lazy evaluation.
4. Iterating with rewindable generators without creating copies of the data. Fallback to array functions when no copies are involved.
5. 100% test coverage.

### Installation

```
composer require linepogl/impartial-pipes
```

## Why use it?

The pipe operator of PHP is a great way to chain functions together. However, it is not perfect because it requires that the chained functions accept exactly one mandatory argument. When this is not the case, we have to resort to workarounds by wrapping the functions in a closure.

```php
// PHP 8.5
$array
|> static fn ($in) => array_map(static fn (int $x) => $x * $x), $in)
|> static fn ($in) => array_filter($in, static fn (int $x) => $x % 2 === 1)
```

This might be solved in a future version of PHP, with a proposed syntax like this:

```php
// PHP > 8.5, if accepted
$array
|> array_map(static fn (int $x) => $x * $x), ...)
|> array_filter(..., static fn (int $x) => $x % 2 === 1)
```

This is a step in the right direction. However, it is still not perfect:
 - We still have to remember the infamously inconsistent order of the arguments.
 - It works only for arrays, but not for iterables, because the standard library offers too few functions for that.

With Impartial Pipes, we can write the same code as this:

```php
// PHP 8.5, with Impartial Pipes
$iterable
|> p_map(static fn (int $x) => $x * $x)
|> p_filter(static fn (int $x) => $x % 2 === 1)
```

### Can I use it before PHP 8.5?

Yes, you can! 

Even if the pipe operator is not available, partial functions can still be used. As a result, we get a syntax that is slightly more consistent than that of the standard library. On top of that, we can use these functions with both arrays and iterables.

```php
// PHP 8.4, with Impartial Pipes
p_filter(static fn (int $x) => $x % 2 === 1)(
  p_map(static fn (int $x) => $x * $x)(
    $iterable
  )
)
```

Alternatively, you can use the `pipe` function as syntax sugar. In this case, the order of the operations is the same as in the pipe operator.

```php
// PHP 8.4, with Impartial Pipes
pipe($iterable)
->to(p_filter(static fn (int $x) => $x % 2 === 1))
->to(p_map(static fn (int $x) => $x * $x))
```

# Full Reference

### Combining partial functions

- [p_merge](doc/Combining/p_merge.md)

### Mapping partial functions

- [p_map](doc/Mapping/p_map.md)
- [p_flat_map](doc/Mapping/p_flat_map.md)
- [p_reindex](doc/Mapping/p_reindex.md)
- [p_values](doc/Mapping/p_values.md)
- [p_keys](doc/Mapping/p_keys.md)
- [p_group_by](doc/Mapping/p_group_by.md)
- [p_order_by](doc/Mapping/p_order_by.md)
- [p_then_by](doc/Mapping/p_then_by.md)

### Filtering partial functions

- [p_filter](doc/Filtering/p_filter.md)
- [p_filter_out](doc/Filtering/p_filter_out.md)
- [p_filter_out_nulls](doc/Filtering/p_filter_out_nulls.md)
- [p_unique](doc/Filtering/p_unique.md)
- [p_take](doc/Filtering/p_take.md)
- [p_take_while](doc/Filtering/p_take_while.md)
- [p_skip](doc/Filtering/p_skip.md)
- [p_skip_while](doc/Filtering/p_skip_while.md)

### Reducing partial functions

- [p_any](doc/Reducing/p_any.md)
- [p_all](doc/Reducing/p_all.md)
- [p_count](doc/Reducing/p_count.md)
- [p_first](doc/Reducing/p_first.md)
- [p_first_or](doc/Reducing/p_first_or.md)
- [p_first_key](doc/Reducing/p_first_key.md)
- [p_first_key_or](doc/Reducing/p_first_key_or.md)
- [p_last](doc/Reducing/p_last.md)
- [p_last_or](doc/Reducing/p_last_or.md)
- [p_last_key](doc/Reducing/p_last_key.md)
- [p_last_key_or](doc/Reducing/p_last_key_or.md)
- [p_sum](doc/Reducing/p_sum.md)
- [p_implode](doc/Reducing/p_implode.md)
- [p_foreach](doc/Reducing/p_foreach.md)
- [p_to_array](doc/Reducing/p_to_array.md)
