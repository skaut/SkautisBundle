[![Build Status](https://travis-ci.org/skaut/SkautisBundle.svg?branch=2.x)](https://travis-ci.org/skaut/SkautisBundle)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/skaut/SkautisBundle/badges/quality-score.png?b=2.x)](https://scrutinizer-ci.com/g/skaut/SkautisBundle/?branch=2.x)
[![Code Coverage](https://scrutinizer-ci.com/g/skaut/SkautisBundle/badges/coverage.png?b=2.x)](https://scrutinizer-ci.com/g/skaut/SkautisBundle/?branch=2.x)
[![Latest Stable Version](https://poser.pugx.org/skautis/skautis-bundle/v/stable.svg)](https://packagist.org/packages/skautis/skautis-bundle)
[![Latest Unstable Version](https://poser.pugx.org/skautis/skautis-bundle/v/unstable.svg)](https://packagist.org/packages/skautis/skautis-bundle)
[![License](https://poser.pugx.org/skautis/skautis-bundle/license.svg)](https://packagist.org/packages/skautis/skautis-bundle)


#SkautisBundle

##Co tento bundle nabizi
 - Napojení na Symfony Service Container
 - Expresivní konfigurace v [YAML jazyce](https://en.wikipedia.org/wiki/YAML)
 - Přihlášení pomoci SkautISu
 - Debugovaní pomocí panelu v Symfony Profileru
 - Zpracování neošetrených SkautIS výjimek
 - Přidání informací k logům
 - Události pro jednoduché rozšíření

##Ukazka
Snadný přítup k datům ze SkautISu
```php
//V controlleru
$userDetail = $this->get('skautis')->user->UserDetail();
$personId = $userDetail->Person_Id;
```

##Profiler
//@TODO images

##Instalace a použití
Podrobný návod na instalaci a použití najdete v [dokumentaci](docs/README.md)

##Minimalni verze PHP
Minimální verze PHP se shoduje s verzí PHP na [lebeda.skauting.cz](http://lebeda.skauting.cz/technicke_informace.php#php). Pokud tomu tak neni vytvorte issue nebo napiste email spravci repozitare.

##Verzovani balicku
Tento Bundle nemá stejné čísla verzí jako hlavní knihovna. Důvod je ten že při každé změně minimálních závislostí se mění major verze v soukadu se [sémantickým verzováním](http://semver.org/)

Abyste předešli problémům s verzovaním doporučuji pečlivě volit verze požadované v composer.json.
* Pro aplikace v produkčním nasazení **použijte "1.0.*" nebo "^1.0"**
* Při vývoji můžete použít například toto "1.-dev" což vám zaručí nejnovější code z major verze 1


