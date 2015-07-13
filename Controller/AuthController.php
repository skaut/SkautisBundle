<?php

namespace SkautisBundle\Controller;

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

        $this->addFlash('notice', 'Byl/a jste prihlasena');

        $redirectRoute = $this->container->getParameter('skautis.after_login_redirect');
        return $this->redirectToRoute($redirectRoute);
    }

    /**
     * Odhlasi uzivatele z is.skaut.cz
     */
    public function logoutAction()
    {
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

        return $this->redirectToRoute("homepage");
    }
}
