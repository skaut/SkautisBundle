#Prihlaseni


##Pro prihlaseni, odhlaseni, registraci pouzivejte symfony routy.
```php
//V controlleru

$loginUrl    = $this->generateUrl('skautis_login')l
$logoutUrl   = $this->generateUrl('skautis_logout')l
$registerUrl = $this->generateUrl('skautis_register');

```

**Nepouzivejte** metody ``$skautis->getLoginUrl()``, ``$skautis->getLogoutUrl()``, ``$skautis->getRegisterUrl()``!