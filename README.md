# Darujme.sk API knižnica pre Laravel

Jednoduchá komunikácia s portálom [Darujme.sk](https://darujme.sk/) prostredníctvom dostupného [API rozhrania](https://documenter.getpostman.com/view/10150431/T1LS9jWA?version=latest).

## Zatiaľ zabezpečuje:

[Zoznam kampaní](#zoznam-kampaní)<br/>
[Zoznam užívateľov](#zoznam-užívateľov)<br/>
[Detail užívateľa na základe ID](#detail-užívateľa-na-základe-id)<br/>
[Zoznam platieb](#zoznam-platieb)

## Inštalácia

Môžete použiť composer:

```bash
composer require sun-ergo-s/darujme-na-laravel:dev-main
```

Taktiež môžete vytvoriť konfiguračný súbor:

```bash php
php artisan vendor:publish --tag="darujme-config"
```

V ```.env``` súbore je potrebné zadefinovať API kľúč, Secret a prihlasovacie údaje ako aj ID organizácie:

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
```

## Dostupné metódy:

### Zoznam kampaní

[API doc referencia](https://documenter.getpostman.com/view/10150431/T1LS9jWA?version=latest#c6746aa9-a41c-4f73-abed-3fb3dae23f72)
```php
$campaigns = Darujme::listOfCampaigns();
``` 

### Zoznam užívateľov

[API doc referencia](https://documenter.getpostman.com/view/10150431/T1LS9jWA?version=latest#5e73414d-6534-445c-a026-a114e97f8b51)
```php
$users = Darujme::listOfUsers();
``` 

### Detail užívateľa na základe ID

[API doc referencia](https://documenter.getpostman.com/view/10150431/T1LS9jWA?version=latest#41329e62-ba05-4430-8456-0719f066d3bc)
```php
$user_detail = Darujme::userDetail("id-uzivatela");
``` 

### Zoznam platieb

[API doc referencia](https://documenter.getpostman.com/view/10150431/T1LS9jWA?version=latest#cf082c5e-c725-4321-8c88-0d889d1b582a)
```php
$list_of_payments = Darujme::listOfPayments();
``` 