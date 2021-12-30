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