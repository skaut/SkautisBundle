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
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

/**
 * Pouziva se pro zahajeni prihlaseni
 */
class SkautisEntryPoint implements AuthenticationEntryPointInterface
{

    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * SkautisEntryPoint constructor.
     */
    public function __construct(RouterInterface $router)
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
