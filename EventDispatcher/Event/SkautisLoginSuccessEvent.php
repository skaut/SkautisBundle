<?php

namespace SkautisBundle\EventDispatcher\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Udalost vyvolana po uspesnem prihlaseni do skautisu
 */
class SkautisLoginSuccessEvent extends Event
{
    const EVENT_NAME = "skautis.login_success";
}
