<?php

namespace SkautisBundle\EventDispatcher\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Udalost vyvolana pred propojenim Symfony uzivatele a Skautis uzivatele
 */
class PreConnectEvent extends Event
{
    const EVENT_NAME = "skautis.pre_connect";
}
