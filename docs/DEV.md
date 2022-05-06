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
composer run-script schemadoc
```

## Generate github pages documentation https://apidae-tourisme.github.io/apidae-php/

```bash
composer run-script schemadoc
composer run-script phpdoc
```

La génération de la doc se fait en plusieurs étapes :

L'appel à schemadoc (les schemas sont générés en .md dans docs/schemas, et en .html dans gh-pages/schemas)

Ensuite un appel à `dev/phpdoc.php` qui génère une "fausse" classe `dev/Client.php` qui permet d'avoir une doc plus élaborée

On aurait pu créer la doc à partir des signatures présentes au dessus de `class Client` dans `src/Client.php` mais on est alors obligé d'utiliser @method et on ne peut pas utiliser @param, @return, @example...

Pour cette raison on préfère générer cette fausse classe `dev/Client.php` qui ne sert qu'à générer la doc avec phpDocumentor.

Une fois le script terminé, le contenu de gh-pages est mis à jour : sur un poste développeur, ce répertoire doit être synchronisé avec : https://github.com/apidae-tourisme/apidae-php/tree/gh-pages
Cette branche contient les fichiers HTML de la doc sur github.io

## Generate inline documentation for autocompletion

L'ajout des commentaires @method dans `src/Client.php` permet l'autocomplétion des IDE.

```bash
composer run-script inlinedoc
```

Le script génère la doc /** ... */ qui va ensuite s'écrire au dessus de `class Client ...` dans `src/Client.php`

**Attention : ce script écrit bien sur un fichier php (`src/Client.php`) : c'est dangereux et ça mérite relecture après chaque régénération**

## Todo

Renommer le package sur packagist :
https://stackoverflow.com/questions/55378780/how-to-rename-a-php-package-in-packagist

Update the name in composer.json on the main branch
Resubmitting the package to packagist using the new name
Mark the old package as "Abandoned" on packagist, and use the new name (apidae-tourisme/apidae-php) in the form so that people get pointed to it when they install with the old name
And no you can't keep your download stats