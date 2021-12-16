
### Exports

[Full documentation](http://dev.apidae-tourisme.com/fr/documentation-technique/v2/exports)

*This feature require the PHP Zip extension and write permission on the filesystem.*

Exports are an asynchronous feature of Apidae allowing you to retrieve a large quantity of data without 
performing a lot of API calls. When a new export is done via Apidae and ready to take care,
your application receive a notification which looks like this:

```php
$exportNotification = $_POST;

// What Apidae sends:
array(
    "statut" => "SUCCESS",
    "reinitialisation" => "false",
    "projetId" => "672",
    "urlConfirmation" => "https://api.apidae-tourisme.com/api/v002/export/confirmation?hash=XXX",
    "ponctuel" => "true",
    "urlRecuperation" => "https://export.apidae-tourisme.com/exports/XXX.zip",
);
```

You **must** store those information and answer Apidae as soon as possible with a success response.

Then, to handle this export, you need to:

1. download the export in a memory efficient way;
1. extract the files locally;
1. do your own logic about what you need;
1. and if everything is OK, you must call "urlConfirmation".

The library handle the first two points and the last one for you!

#### Download and extract export

Simply call the `getExportFiles` method and provide the `urlRecuperation`:

```php
$exportFiles = $client->getExportFiles([
    'url' => $exportNotification['urlRecuperation']
]);
```

`$exportFiles` is then a [`Finder`](http://symfony.com/doc/current/components/finder.html) object you can iterate on:

```php
// Get all the files and display their content
foreach ($exportFiles->files() as $file) {
    echo $file->getRealpath();
    echo '<br>';
    echo $file->getContents();
    echo '<br>';
}

// Filter files by name...
foreach ($exportFiles->name('objets_lies_modifies-14*') as $file) {
    echo $file->getRealpath();
}

// Decode file contents (XML or JSON, see your Apidae settings)
foreach ($exportFiles->files() as $file) {
    // $xml = simplexml_load_string($file->getContents());
    // print_r($xml);

    $json = \GuzzleHttp\Utils::jsonDecode($file->getContents(), true);
    print_r($json);
}
```

#### Confirmation

When you have finished your tasks, you must confirm to Apidae that everything went fine.

```php
// With the export hash
$client->confirmExport(['hash' => 'XXX']);

// Or, with the full URL given in the notification
$client->confirmExport(['hash' => $exportNotification['urlConfirmation']]);
```

#### Cleaning up files

All the files are downloaded and extracted in the `exportDir` directory (see options).

We provide a method to clean this directory after you have done your business logic with the files:

```php
$client->cleanExportFiles();
```
