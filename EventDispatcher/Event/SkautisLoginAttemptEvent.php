<?php

namespace SkautisBundle\EventDispatcher\Event;

use Symfony\Component\EventDispatcher\Event;

class SkautisLoginAttemptEvent extends Event
{
    const EVENT_NAME = "skautis.login_attempt";

}