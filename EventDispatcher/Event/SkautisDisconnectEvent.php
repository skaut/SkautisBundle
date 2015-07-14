<?php

namespace SkautisBundle\EventDispatcher\Event;

use Symfony\Component\EventDispatcher\Event;

class SkautisDisconnectEvent extends Event
{
    const EVENT_NAME = "skautis.disconnect";

}