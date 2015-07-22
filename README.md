[![Build Status](https://travis-ci.org/skaut/SkautisBundle.svg?branch=2.x)](https://travis-ci.org/skaut/SkautisBundle)[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/skaut/SkautisBundle/badges/quality-score.png?b=2.x)](https://scrutinizer-ci.com/g/skaut/SkautisBundle/?branch=2.x)[![Code Coverage](https://scrutinizer-ci.com/g/skaut/SkautisBundle/badges/coverage.png?b=2.x)](https://scrutinizer-ci.com/g/skaut/SkautisBundle/?branch=2.x)[![Latest Stable Version](https://poser.pugx.org/skautis/skautis-bundle/v/stable.svg)](https://packagist.org/packages/skautis/skautis-bundle) [![Latest Unstable Version](https://poser.pugx.org/skautis/skautis-bundle/v/unstable.svg)](https://packagist.org/packages/skautis/skautis-bundle) [![License](https://poser.pugx.org/skautis/skautis-bundle/license.svg)](https://packagist.org/packages/skautis/skautis-bundle)


#SkautisBundle

##Co tento bundle nabizi
 - Napojeni na Symfony Service Container
 - Expresivni konfigurace skrze Symfony
 - Prihlaseni pomoci Skautisu
 - Debugovani pomoci panelu v Symfony Profileru
 - Zpracovani neosetrenych skautis vyjimek
 - Pridani informaci k logum
 - Udalosti pro zjednodusenne rozsireni\
 
##Ukazka
Snadny pritup k datum ze skautisu
```php
//V controlleru
$userDetail = $this->get('skautis')->user->UserDetail();
$personId = $userDetail->Person_Id;
```

##Profiler
//@TODO images

##Instalace
Podrobny navod najdete v [dokumentaci](docs/)

##Minimalni verze PHP
Je shodna s [lebeda.skauting.cz](http://lebeda.skauting.cz/technicke_informace.php#php). Pokud tomu tak neni vytvorte issue nebo napiste email spravci repozitare.

##Verzovani balicku
Abyste predesli problemum s verzovanim doporucuji peclive volit verze pozadovane v composer.json.
Pro aplikace v produkcnim nasazeni **durazne nedoporucuji pouzivat omezeni typu "*@dev" "*" ">=2" ">=2.0" "2.0@dev"**
Naopak vhodny je vyraz typu "2.0.*" nebo "~2.0.0"

[Vice informaci o verzovani](http://semver.org/)
