
# Reference

Like normal search, you do not need to provide the API credentials to use those methods.

[Full documentation](http://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services#referentiel)

## Cities

```php
$cities = $client->getReferenceCity([
    'query' => '{"codesInsee": ["38534", "69388", "74140"]}'
]);
```

## Elements

```php
$elements = $client->getReferenceElement([
    'query' => '{"elementReferenceIds": [2, 118, 2338]}'
]);
```

## Internal Criteria

```php
$criteria = $client->getReferenceInternalCriteria([
    'query' => '{"critereInterneIds":[1068, 2168]}'
]);
```

## Selections

```php
$selections = $client->getReferenceSelection([
    'query' => '{"selectionIds":[64, 5896]}'
]);
```
