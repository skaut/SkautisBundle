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
 // Nasledujici je potreba dopsat
 
 //Bundle vyzadovane SkautisBundlem
 new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
 
 //Samotny SkautisBundle
 new SkautisBundle\SkautisBundle(),
)
```

##Konfigurace
Pro uspesne pouzivani je nutne konfigurovat ``app/config/config.yml``
```yaml
#Konfigurace veci ktere skautis bundle potrebuje
monolog:
    channels: ["skautis"]
    
doctrine_cache: 
    providers: 
        skautis_cache: 
            type: array #Zde lze pouzit i dlouhodobejsi cache, ale pozor Skautis obsahuje soukrome informace!


#Kounfigurace skautis bundle
skautis:
    app_id:  "ID VYGENEROVANE SPRAVCEM APLIKACI SKAUTISU"
    doctrine_cache_provider:  'doctrine_cache.providers.skautis_cache' #Definovano u doctrine_cache
```
**Kompletni seznam moznych nastavni ziskate prikazem**
```bash
    ./app/console config:dump-reference SkautisBundle 
```

Pridejte routy do routing.yml
```yaml
#app/config/routing.yml
skautis_bundle:
    resource: "@SkautisBundle/Resources/config/routing.yml"
    prefix:   /
```