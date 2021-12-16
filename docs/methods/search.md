
#### List search results

You can send search in a couple of ways:

```php
// As JSON string
$search = $client->searchObject(['query' => '{"searchQuery": "vélo"}']);

// As PHP Array
$search = $client->searchObject(['query' => [
    "searchQuery" => "vélo",
    "count" => 20,
    "first" => 10,
]]);

// With the credentials it works too (but we handle them for you)
$search = $client->searchObject(['query' => [
    "searchQuery" => "vélo"
    "apiKey" => 'XXX',
    "projetId" => 1,
]]);
```

#### Search with identifier

When you only need the object ids:

```php
$client->searchObjectIdentifier(['query' => '{"searchQuery": "vélo"}']);
```
