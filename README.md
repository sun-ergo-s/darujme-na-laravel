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

## Použitie

```php

use SunErgoS\DarujmeNaLaravel\Facades\Darujme;

$campaigns = Darujme::listOfCampaigns("id-organizácia");
$users = Darujme::listOfUsers();
$user_detail = Darujme::userDetail("id-uzivatela");

``` 