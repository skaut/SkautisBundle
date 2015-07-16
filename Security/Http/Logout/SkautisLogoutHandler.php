<?php
/**
 * Created by PhpStorm.
 * User: Jindra
 * Date: 12. 7. 2015
 * Time: 13:33
 */

namespace SkautisBundle\Security\Http\Logout;

use Skautis\Skautis;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;

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
        return new RedirectResponse($this->skautis->getLogoutUrl());
    }


}