# Pipes

A library with partial functions suitable for the pipe operator.

## Usage

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
```php
['a' => 1, 'b' => 2] 
|> it_map(
   static fn (int $value, string $key) => $key . $value, // values
   static fn (int $value, string $key) => $value . $key, // keys
);
// ['1a' => 'a1', '2b' => 'b2']
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
