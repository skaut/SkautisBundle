<?php

namespace SkautisBundle\Security\Http\Logout;

use Skautis\Skautis;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;

/**
 * Trida provadejici odhlaseni
 */
class SkautisLogoutHandler implements LogoutSuccessHandlerInterface
{

    /**
     * @var Skautis
     */
    protected $skautis;

    /**
     * SkautisLogoutHandler constructor.
     * @param Skautis $skautis
     */
    public function __construct(Skautis $skautis)
    {
        $this->skautis = $skautis;
    }


    /**
     * @inheritdoc
     */
    public function onLogoutSuccess(Request $request)
    {
        $response = new RedirectResponse($this->skautis->getLogoutUrl());
        $this->skautis->getUser()->resetLoginData();
        return $response;
    }


}
