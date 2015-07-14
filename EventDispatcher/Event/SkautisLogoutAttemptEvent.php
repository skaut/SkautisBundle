<?php

namespace SkautisBundle\EventDispatcher\Event;

use Symfony\Component\EventDispatcher\Event;

class SkautisLogoutAttemptEvent extends Event
{
    const EVENT_NAME = "skautis.logout_attempt";

}