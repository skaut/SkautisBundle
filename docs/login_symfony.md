#Symfony login
Symfony ma vlastni authentizacni system, zde se dozvite jak ho propojit se skautisem.
Navic vetsine aplikaci nebude stacit pouze uzivatel ze skautisu. Bude vyzadovat lokalni data, napriklad pro mapovani autoru clanku blogu v relacni databazi.
Authentikace je jedna z neslozitejsich komponent Symfony a zaroven jedna z nejdulezitejsich. Doporucuji precist si o [Symfony Security](http://symfony.com/doc/current/book/security.html)

##Instalace
Po nainstalovani bundle je potreba vytvorit a nakonfigurovat novy firewall.
```yaml
//security.yml
security:
    providers:
    
    firewalls:
        dev:
            pattern: ^/(_(profiler|wdt)|css|images|js)/
            security: false

        skautis_secured:
            pattern:   ^/
            anonymous: true
            stateless: true
            skautis:
                autoregister: true
                confirm_auth: false
            logout:
              success_handler: skautis.security_authentication.skautis_logout_handler

    access_control:
        - { path: ^/login, roles: IS_AUTHENTICATED_ANONYMOUSLY }
```
        
##Prihlaseni uzivatele

###Propojeni s existujicim uzivatelem
V pripade ze Vas web ci webova aplikace pouziva vlastni registraci, staci uzivatele pouze propojit se skautis uzivatelem.
K tomu staci uzivatele, prihlaseneho jak do skautisu tak do aplikace presmerovat na routu ```skautis_connect``` 

###Autoregistrace
Pro zjednoduseni veci pro uzivatele je implementovan mechanizmus autoregistrace. Pri prihlaseni do skautisu je automaticky vytvoren symfony uzivatel a propojen.
Vytvoreni Symfony uzivatele je vzdy specificke pro aplikaci, proto je nutne zprostredkovat sluzbu ```skautis.security.authentication.registrator``` ktera implementuje ```UserRegistratorInterface```

Priklad implementace:
```php
class DoctrineRegistrator implements  UserRegistratorInterface
{

    /**
     * @var Skautis
     */
    protected $skautis;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * DoctrineRegistrator constructor.
     * @param Skautis $skautis
     * @param EntityManager $entityManager
     */
    public function __construct(Skautis $skautis, EntityManager $entityManager)
    {
        $this->skautis = $skautis;
        $this->entityManager = $entityManager;
    }


    /**
     * @return string Username of newly registered user
     */
    public function registerUser()
    {
        $data = $this->skautis->user->UserDetail();

        $user = new User();
        $user->setUsername($data->UserName);
        $user->setIsActive(true);
        $user->setPassword("password");
        $user->setEmail("email@email.cz");

        try {
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }
        catch(\Exception $e) {
            \dump($e);
        }

        return $user->getUsername();
    }

}
```

Priklad vytvoreni sluzby:
```yml
services:
    skautis.security.authentication.registrator:
        class: Skautis\DemoBundle\Security\DoctrineRegistrator
        arguments: [ "@skautis", "@doctrine.orm.entity_manager" ]
```