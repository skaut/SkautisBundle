<?php

namespace SkautisBundle\EventDispatcher\Event;

use Symfony\Component\EventDispatcher\Event;

class SkautisLogoutSuccessEvent extends Event
{
    const EVENT_NAME = "skautis.logout_success";

}