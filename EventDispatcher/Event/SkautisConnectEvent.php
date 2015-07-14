<?php

namespace SkautisBundle\EventDispatcher\Event;

use Symfony\Component\EventDispatcher\Event;

class SkautisConnectEvent extends Event
{
    const EVENT_NAME = "skautis.connect";

}