# Contributor documentation

**Only for contributors of apidae-php.**

**If you just want to use apidae-php, you do not have to follow any of this steps.**

Anything following assume you already runned `composer install`.

---

## Run tests

Functional tests require a valid `config.inc.php`

```
composer run-script tests
```
or
```
vendor/bin/phpunit tests/unit
vendor/bin/phpunit tests/functional
```

## Run quality tests
```
composer run-script phpstan
```
or
```
vendor/bin/phpstan --level=?
```

## Regenerate schema documentation

Require https://github.com/coveooss/json-schema-for-humans

Can be installed locally only

```bash
composer run-script schemaDoc
```

## Todo

Renommer le package sur packagist :
https://stackoverflow.com/questions/55378780/how-to-rename-a-php-package-in-packagist

Update the name in composer.json on the main branch
Resubmitting the package to packagist using the new name
Mark the old package as "Abandoned" on packagist, and use the new name (apidae-tourisme/apidae-php) in the form so that people get pointed to it when they install with the old name
And no you can't keep your download stats