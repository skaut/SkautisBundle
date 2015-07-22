#Pouziti
Po uspesne Instalaci a Konfiguraci bude v Dependency Injection Containeru existovat plne nakonfigurovana sluzba ``skautis``.

##Pouziti v controlleru
V pripade ze pouzivate defaultni symfony controller staci v jakekoliv akci pristoupit k ``$this->get('skautis')``
Priklad
```php
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $skautis = $this->get('skautis');
    
        if (!$skautis->getUser()->isLoggedIn()) {
            return $this->redirect('skautis_login');
        }
    }
}
```


##Pouziti s Dependecy Injection
Skautis je definovan jako bezna sluzba, da se tedy pouzit jako parametr jine sluzby v DI.

```yaml
data_collector.skautis_collector:
    class: "%skautis.data_collector_class%"
    arguments:
        - @skautis
```