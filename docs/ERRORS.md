
# Handline errors

We recommend that all API calls are done in a try block.

## API Errors

Errors from the API are wrapped in `ApidaePHP\Exception\ApidaeException`.

```php
try {
    $cities = $client->getReferenceCity(['query' => '{"codesInsee": ["38534", "69388", "74140"]}']);
} catch (\ApidaePHP\Exception\ApidaeException $e) {
    echo $e->getMessage();
}
```

The Exception message is **not** for public display as it may contains credentials.

## Validation Errors

Validations errors happens before the query and assume you did not respect the defined schema for a method.

They are represent by `GuzzleHttp\Command\Exception\CommandException`.

## Metadata Errors

The JSON used for metadata editing is complex and come with his own Exception `ApidaePHP\Exception\InvalidMetadataFormatException`.
