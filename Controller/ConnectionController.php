<?php

namespace SkautisBundle\Controller;

use SkautisBundle\EventDispatcher\Event\SkautisConnectEvent;
use SkautisBundle\EventDispatcher\Event\SkautisDisconnectEvent;
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

        $event = new SkautisConnectEvent();
        $this->get("event_dispatcher")->dispatch(SkautisConnectEvent::EVENT_NAME, $event);

        return $this->redirectToRoute("homepage");
    }

    /**
     * Rozpoji uzivatele
     */
    public function disconnectAction() {

        $user = $this->getUser();
        if (!$user instanceof UserInterface) {
            $this->addFlash("error", "Nelze rozpojit ucty! Nikdo neni prihlasen.");
            return $this->redirectToRoute("homepage");
        }

        /** @var SkautisUserConnectorInterface $connector */
        $connector = $this->get("skautis.security.authentication.connector");
        $connector->disconnect($user->getUsername());

        $event = new SkautisDisconnectEvent();
        $this->get("event_dispatcher")->dispatch(SkautisDisconnectEvent::EVENT_NAME, $event);

        return $this->redirectToRoute("homepage");
    }
}