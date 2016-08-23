<?php

namespace SkautisBundle\EventDispatcher\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Udalost vyvolana po propojeni Symfony uzivatele se Skautis uzivatelem
 */
class SkautisAfterConnectEvent extends Event
{
    const EVENT_NAME = "skautis.after_connect";
}
