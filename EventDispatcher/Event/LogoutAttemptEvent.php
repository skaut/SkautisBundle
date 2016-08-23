<?php

namespace SkautisBundle\EventDispatcher\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Udalost vyvolana pri zacatku odlhaseni ze skautisu (pred presmerovanim na servery skautisu)
 */
class LogoutAttemptEvent extends Event
{
    const EVENT_NAME = "skautis.logout_attempt";
}
