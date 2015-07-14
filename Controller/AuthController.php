<?php

namespace SkautisBundle\Controller;

use SkautisBundle\EventDispatcher\Event\SkautisConnectEvent;
use SkautisBundle\EventDispatcher\Event\SkautisDisconnectEvent;
use SkautisBundle\EventDispatcher\Event\SkautisLoginAttemptEvent;
use SkautisBundle\EventDispatcher\Event\SkautisLoginSuccessEvent;
use SkautisBundle\EventDispatcher\Event\SkautisLogoutAttemptEvent;
use SkautisBundle\EventDispatcher\Event\SkautisLogoutSuccessEvent;
use SkautisBundle\Security\Authentication\DoctrineUserConnector;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Trida pro authentikaci uzivatele pomoci is.skaut.cz
 * Uzivatele neuklada do lokalni databaze
 */
class AuthController extends Controller
{
    /**
     * Presmeruje uzivatele na is.skaut.cz login
     */
    public function loginAction()
    {
        $event = new SkautisLoginAttemptEvent();
        $this->get("event_dispatcher")->dispatch(SkautisLoginAttemptEvent::EVENT_NAME, $event);

	    $loginUrl = $this->get('skautis')->getLoginUrl();
        return $this->redirect($loginUrl);
    }

    /**
     * Overi prihlaseni uzivatele. Skautis presmeruje sem po uspesnem prihlaseni.
     */
    public function loginConfirmAction(Request $request)
    {

        $skautis = $this->get('skautis');
        $skautis->setLoginData($request->request->all());

        if (!$skautis->getUser()->isLoggedIn(true)) {
            $skautis->getUser()->resetLoginData();
            return $this->redirect($skautis->getLoginUrl());
        }

        $event = new SkautisLoginSuccessEvent();
        $this->get("event_dispatcher")->dispatch(SkautisLoginSuccessEvent::EVENT_NAME, $event);

        $this->addFlash('notice', 'Byl/a jste prihlasena');

        $redirectRoute = $this->container->getParameter('skautis.after_login_redirect');
        return $this->redirectToRoute($redirectRoute);
    }

    /**
     * Odhlasi uzivatele z is.skaut.cz
     */
    public function logoutAction()
    {

        $event = new SkautisLogoutAttemptEvent();
        $this->get("event_dispatcher")->dispatch(SkautisLogoutAttemptEvent::EVENT_NAME, $event);

	    $logoutUrl = $this->get('skautis')->getLogoutUrl();
        return $this->redirect($logoutUrl);
    }

    /**
     * Odhlasi uzivatele z is.skaut.cz
     */
    public function logoutConfirmAction()
    {
        $this->get('session')->invalidate();
        $this->addFlash('notice', 'Byl/a jste odhlasena');

        $event = new SkautisLogoutSuccessEvent();
        $this->get("event_dispatcher")->dispatch(SkautisLogoutSuccessEvent::EVENT_NAME, $event);

        $redirectRoute = $this->container->getParameter('skautis.after_logout_redirect');
        return $this->redirectToRoute($redirectRoute);
    }

    /**
     * Presmeruje uzivatele na registracni furmalr na is.skaut.cz
     */
    public function registerAction()
    {

	    $registerUrl = $this->get('skautis')->getRegisterUrl();
        return $this->redirect($registerUrl);
    }

    public function connectAction() {

        $userDetail = $this->get("skautis")->user->UserDetail();
        $personId = $userDetail->ID_Person;

        $user = $this->getUser();
        if (!$user instanceof UserInterface) {
            $this->addFlash("error", "Nelze propojit ucty! Nikdo neni prihlasen.");
            return $this->redirectToRoute("homepage");
        }

        /** @var DoctrineUserConnector $connector */
        $connector = $this->get("skautis.security.authentication.connector");
        $connector->connect($personId, $user->getUsername());

        $event = new SkautisConnectEvent();
        $this->get("event_dispatcher")->dispatch(SkautisConnectEvent::EVENT_NAME, $event);

        return $this->redirectToRoute("homepage");
    }

    public function disconnectAction() {

        $user = $this->getUser();
        if (!$user instanceof UserInterface) {
            $this->addFlash("error", "Nelze rozpojit ucty! Nikdo neni prihlasen.");
            return $this->redirectToRoute("homepage");
        }

        /** @var DoctrineUserConnector $connector */
        $connector = $this->get("skautis.security.authentication.connector");
        $connector->disconnect($user->getUsername());

        $event = new SkautisDisconnectEvent();
        $this->get("event_dispatcher")->dispatch(SkautisDisconnectEvent::EVENT_NAME, $event);

        return $this->redirectToRoute("homepage");
    }
}
