<?php

namespace SkautisBundle\Controller;

use SkautisBundle\EventDispatcher\Event\SkautisLoginAttemptEvent;
use SkautisBundle\EventDispatcher\Event\SkautisLoginSuccessEvent;
use SkautisBundle\EventDispatcher\Event\SkautisLogoutAttemptEvent;
use SkautisBundle\EventDispatcher\Event\SkautisLogoutSuccessEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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

}
