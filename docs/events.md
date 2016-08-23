#Udalosti

Pro snadne rozsireni bundle nabzi nekolik udalosti. Tyto udalosti jsou vyvolany pred a po zasadnich krocich, u kterych
se da cekat nejaka akce aplikace. Vsechny Skautis udalosti se nachazeji v namespace ``SkautisBundle\EventDispatcher\Event``

##Existujici udalsoti
```php
use SkautisBundle\EventDispatcher\Event\LoginAttemptEvent
use SkautisBundle\EventDispatcher\Event\LoginSuccessEvent

use SkautisBundle\EventDispatcher\Event\LogoutAttemptEvent
use SkautisBundle\EventDispatcher\Event\LogoutSuccessEvent

use SkautisBundle\EventDispatcher\Event\PreConnectEvent
use SkautisBundle\EventDispatcher\Event\AfterConnectEvent

use SkautisBundle\EventDispatcher\Event\PreDisConnectEvent
use SkautisBundle\EventDispatcher\Event\AfterDisconnectEvent
```

Vice informaci o [udalostech](http://symfony.com/doc/current/components/event_dispatcher/introduction.html)
