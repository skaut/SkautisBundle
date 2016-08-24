<?php

namespace SkautisBundle\Controller;

use SkautisBundle\EventDispatcher\Event\AfterConnectEvent;
use SkautisBundle\EventDispatcher\Event\AfterDisconnectEvent;
use SkautisBundle\EventDispatcher\Event\PreConnectEvent;
use SkautisBundle\EventDispatcher\Event\PreDisconnectEvent;
use SkautisBundle\Security\Authentication\Connector\UserConnectorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Controller pro propojeni skautis uzivatele se symfony uzivatelem
 */
class ConnectionController extends Controller
{
    /**
     * Propoji uzivatele
     */
    public function connectAction()
    {

        $event = new PreConnectEvent();
        $this->get("event_dispatcher")->dispatch(PreConnectEvent::EVENT_NAME, $event);

        $userDetail = $this->get("skautis")->user->UserDetail();
        $personId = $userDetail->ID_Person;

        $user = $this->getUser();
        if (!$user instanceof UserInterface) {
            $this->addFlash("error", "Nelze propojit ucty! Nikdo neni prihlasen.");
            return $this->redirectToRoute("homepage");
        }

        /** @var UserConnectorInterface $connector */
        $connector = $this->get("skautis.security.authentication.connector");
        $connector->connect($personId, $user->getUsername());

        $event = new AfterConnectEvent();
        $this->get("event_dispatcher")->dispatch(AfterConnectEvent::EVENT_NAME, $event);

        return $this->redirectToRoute("homepage");
    }

    /**
     * Rozpoji uzivatele
     */
    public function disconnectAction()
    {

        $event = new PreDisconnectEvent();
        $this->get("event_dispatcher")->dispatch(PreDisconnectEvent::EVENT_NAME, $event);

        $user = $this->getUser();
        if (!$user instanceof UserInterface) {
            $this->addFlash("error", "Nelze rozpojit ucty! Nikdo neni prihlasen.");
            return $this->redirectToRoute("homepage");
        }

        /** @var UserConnectorInterface $connector */
        $connector = $this->get("skautis.security.authentication.connector");
        $connector->disconnect($user->getUsername());

        $event = new AfterDisconnectEvent();
        $this->get("event_dispatcher")->dispatch(AfterDisconnectEvent::EVENT_NAME, $event);

        return $this->redirectToRoute("homepage");
    }
}
