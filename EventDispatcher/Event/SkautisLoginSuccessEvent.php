<?php

namespace SkautisBundle\EventDispatcher\Event;

use Symfony\Component\EventDispatcher\Event;

class SkautisLoginSuccessEvent extends Event
{
    const EVENT_NAME = "skautis.login_success";

}