<?php

namespace SkautisBundle\EventDispatcher\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Udalost vyvolana po rozpojeni Symfony uzivatele a Skautis uzivatele
 */
class AfterDisconnectEvent extends Event
{
    const EVENT_NAME = "skautis.after_disconnect";
}
