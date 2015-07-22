#Instalace

##Vlozeni do symfony

Detailni informace o tom jak pracovat s Bundle najdete v [Symfony navodu na instalace bundle](http://symfony.com/doc/current/cookbook/bundles/installation.html)

Pridejte zavislost do [composeru](https://getcomposer.org/doc/00-intro.md)
```bash
composer require "skautis/skautis-bundle": "*@dev";
```
Upravte soubor app/AppKernell.php
```php
$bundle = array(
 // Nejaky kod tu uz bude
 // Nasledujici radek je potreba dopsat
 new SkautisBundle\SkautisBundle();
)
```

##Konfigurace
Pro uspesne pouzivani je nutne konfigurovat ``app/config/config.yml``
```yaml
skautis:
    app_id:  "ID VYGENEROVANE SPRAVCEM APLIKACI SKAUTISU"
```
###Kompletni seznam moznych nastavni ziskate prikazem
```bash
    ./app/console config:dump-reference SkautisBundle 
```