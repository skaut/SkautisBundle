<?php

namespace SkautisBundle\Controller;

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
        return $this->redirectToRoute("homepage");
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

        return $this->redirectToRoute("homepage");
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
