#SkautisBundle

##Instalace
Detailni informace o tom jak pracovat s Bundle najdete v [Symfony navodu na instalace bundle](http://symfony.com/doc/current/cookbook/bundles/installation.html)

Pridejte zavislost do [composeru](https://getcomposer.org/doc/00-intro.md)
```
composer require "skautis/skautis-bundle": "*@dev";
```
Upravte soubor app/AppKernell.php
```
$bundle = array(
 // Nejaky kod tu uz bude
 // Nasledujici radek je potreba dopsat
 new SkautisBundle\SkautisBundle();
)
```

##Konfigurace
Pro uspesne pouzivani je nutne konfigurovat ``app/config/config.yml``
```
skautis:
    app_id:  "ID VYGENEROVANE SPRAVCEM APLIKACI"
```
Kompletni seznam moznych nastavni ziskate prikazem
```./app/console config:dump-reference SkautisBundle ```

##Pouziti
Po uspesne Instalaci a Konfiguraci bude v Dependency Injection Containeru existovat plne nakonfigurovana sluzba ``skautis``.
Da se k ni dostat napriklad v Controlleru pomoci ``$this->get('skautis')``

##Testy
Momentalne existuji dva druhy testu ``Unit`` a ``Integration``.

###Unit
Se spousti pri samostatnem vyvoji kodu bundle
```
cd SkautisBundle;
phpunit;
```

###Integration
Se spousti v prostredi Symfony aplikace do ktere je tento bundle nainstalovan
Spusteni:
```
cd "Muj/Symfony/Projekt/Root";
phpunit -c app /vendor/skautis/skautis_bundle/Tests;
```
