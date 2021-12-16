
# Agenda

Like normal search, you do not need to provide the API credentials to use those methods.

- [Full request documentation](http://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/format-des-recherches)
- [Response format documentation](http://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/formats-de-reponse)

## `searchAgenda()` or `agendaSimpleListObjetsTouristiques()`
[v002/agenda/simple/list-objets-touristiques/](https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services/v002agendasimplelist-objets-touristiques)

```php
$client->searchAgenda(['query' => '{"searchQuery": "vélo"}']);
$client->agendaSimpleListObjetsTouristiques(['query' => '{"searchQuery": "vélo", "count": 61, "responseFields": ["nom"]}']);
```

## `searchAgendaIdentifier()` or `agendaSimpleListIdentifiants()`
[v002/agenda/simple/list-identifiants/](https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services/v002agendasimplelist-identifiants)

```php
$client->searchAgendaIdentifier(['query' => '{"searchQuery": "vélo"}']);
```

## `searchDetailedAgenda()` or `agendaDetailleListObjetsTouristiques()`
[v002/agenda/detaille/list-objets-touristiques/](https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services/v002agendadetaillelist-objets-touristiques)
```php
$client->searchDetailedAgenda(['query' => '{"searchQuery": "vélo"}']);
```

## `searchDetailedAgendaIdentifier()` or `agendaDetailleListIdentifiants()`
[v002/agenda/detaille/list-identifiants/](https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services/v002agendadetaillelist-identifiants)
```php
$client->searchDetailedAgendaIdentifier(['query' => '{"searchQuery": "vélo"}']);
```