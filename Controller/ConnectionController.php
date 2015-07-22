<?php

namespace SkautisBundle\Controller;

use SkautisBundle\EventDispatcher\Event\SkautisAfterConnectEvent;
use SkautisBundle\EventDispatcher\Event\SkautisAfterDisconnectEvent;
use SkautisBundle\EventDispatcher\Event\SkautisPreConnectEvent;
use SkautisBundle\EventDispatcher\Event\SkautisPreDisconnectEvent;
use SkautisBundle\Security\Authentication\SkautisUserConnectorInterface;
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
    public function connectAction() {

        $event = new SkautisPreConnectEvent();
        $this->get("event_dispatcher")->dispatch(SkautisPreConnectEvent::EVENT_NAME, $event);

        $userDetail = $this->get("skautis")->user->UserDetail();
        $personId = $userDetail->ID_Person;

        $user = $this->getUser();
        if (!$user instanceof UserInterface) {
            $this->addFlash("error", "Nelze propojit ucty! Nikdo neni prihlasen.");
            return $this->redirectToRoute("homepage");
        }

        /** @var SkautisUserConnectorInterface $connector */
        $connector = $this->get("skautis.security.authentication.connector");
        $connector->connect($personId, $user->getUsername());

        $event = new SkautisAfterConnectEvent();
        $this->get("event_dispatcher")->dispatch(SkautisAfterConnectEvent::EVENT_NAME, $event);

        return $this->redirectToRoute("homepage");
    }

    /**
     * Rozpoji uzivatele
     */
    public function disconnectAction() {

        $event = new SkautisPreDisconnectEvent();
        $this->get("event_dispatcher")->dispatch(SkautisPreDisconnectEvent::EVENT_NAME, $event);

        $user = $this->getUser();
        if (!$user instanceof UserInterface) {
            $this->addFlash("error", "Nelze rozpojit ucty! Nikdo neni prihlasen.");
            return $this->redirectToRoute("homepage");
        }

        /** @var SkautisUserConnectorInterface $connector */
        $connector = $this->get("skautis.security.authentication.connector");
        $connector->disconnect($user->getUsername());

        $event = new SkautisAfterDisconnectEvent();
        $this->get("event_dispatcher")->dispatch(SkautisAfterDisconnectEvent::EVENT_NAME, $event);

        return $this->redirectToRoute("homepage");
    }
}