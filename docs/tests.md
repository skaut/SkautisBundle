#Testy
Momentalne existuji dva druhy testu ``Unit`` a ``Integration``.

##Unit
Se spousti pri samostatnem vyvoji kodu bundle
```bash
cd SkautisBundle;
phpunit;
```

##Integration
Se spousti v prostredi Symfony aplikace do ktere je tento bundle nainstalovan
Spusteni:
```bash
cd "Muj/Symfony/Projekt/Root";
phpunit -c app /vendor/skautis/skautis_bundle/Tests;
```