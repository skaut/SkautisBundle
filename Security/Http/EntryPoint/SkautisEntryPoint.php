<?php
/**
 * Created by PhpStorm.
 * User: Jindra
 * Date: 12. 7. 2015
 * Time: 21:04
 */

namespace SkautisBundle\Security\Http\EntryPoint;

use Skautis\Skautis;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

class SkautisEntryPoint implements AuthenticationEntryPointInterface
{

    /**
     * @var Router
     */
    protected $router;

    /**
     * SkautisEntryPoint constructor.
     * @param Skautis $skautis
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }


    /**
     * @inheritdoc
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new RedirectResponse($this->router->generate("skautis_login"));
    }

}