# Darujme.sk API knižnica pre Laravel

Jednoduchá komunikácia s portálom Darujme.sk prostredníctvom dostupného API rozhrania

## Zatiaľ zabezpečuje:

1. Detail užívateľa na základe ID
2. Zoznam používateľov
3. Zoznam kampaní

## Inštalácia

Môžete použiť composer:

```bash
composer require sun-ergo-s/darujme-na-laravel:dev-main
```

Taktiež môžete vytvoriť konfiguračný súbor:

```bash php
php artisan vendor:publish --tag="darujme-config"
```

V .env súbore je potrebné zadefinovať API kľúč, Secret a prihlasovacie údaje ako aj ID organizácie:

```
DARUJME_API_KEY=api_kluc_poskytnuty_prevadzkovatelom_darujme_sk
DARUJME_API_SECRET=secret_kluc_poskytnuty_prevadzkovatelom_darujme_sk
DARUJME_USERNAME=vase_prihlasovacie_meno_na_portal
DARUJME_PASSWORD=vase_heslo
DARUJME_ORGANIZATION_ID=id_vasej_organizacie
```

## Použitie

```php

use SunErgoS\DarujmeNaLaravel\Facades\Darujme;

$campaigns = Darujme::listOfCampaigns();
$users = Darujme::listOfUsers();
$user_detail = Darujme::userDetail("id-uzivatela");

``` 