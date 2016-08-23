<?php

namespace SkautisBundle\EventDispatcher\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Udalost vyvolana pri zacatku prihlaseni uzivatele do skautisu (pred presmerovanim na servery skautisu)
 */
class LoginAttemptEvent extends Event
{
    const EVENT_NAME = "skautis.login_attempt";
}
