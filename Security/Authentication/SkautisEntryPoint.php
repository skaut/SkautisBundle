<?php
/**
 * Created by PhpStorm.
 * User: Jindra
 * Date: 12. 7. 2015
 * Time: 21:04
 */

namespace SkautisBundle\Security\Authentication;

use Skautis\Skautis;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

class SkautisEntryPoint implements AuthenticationEntryPointInterface
{

    /**
     * @var Skautis
     */
    protected $skautis;

    /**
     * SkautisEntryPoint constructor.
     * @param Skautis $skautis
     */
    public function __construct(Skautis $skautis)
    {
        $this->skautis = $skautis;
    }


    /**
     * @inheritdoc
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new RedirectResponse($this->skautis->getLoginUrl());
    }

}