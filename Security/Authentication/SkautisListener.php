<?php

namespace SkautisBundle\Security\Authentication;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Firewall\ListenerInterface;
use SkautisBundle\Security\Authentication\SkautisToken;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Skautis\Skautis;
use Symfony\Component\Security\Http\Firewall\AbstractAuthenticationListener;

class SkautisListener implements ListenerInterface
{

    /**
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * @var AuthenticationManagerInterface
     */
    protected $authenticationManager;

    /**
     * @var Skautis
     */
    protected $skautis;

    /**
     * @var SkautisUserConnectorInterface
     */
    protected $userConnector;

    /**
     * SkautisListener constructor.
     * @param TokenStorageInterface $tokenStorage
     * @param AuthenticationManagerInterface $authenticationManager
     * @param SkautisUserConnectorInterface $userConnector
     * @param Skautis $skautis
     */
    public function __construct(TokenStorageInterface $tokenStorage, AuthenticationManagerInterface $authenticationManager, SkautisUserConnectorInterface $userConnector, Skautis $skautis)
    {
        $this->tokenStorage = $tokenStorage;
        $this->authenticationManager = $authenticationManager;
        $this->userConnector = $userConnector;
        $this->skautis = $skautis;
    }


    /**
     * @inheritdoc
     */
    public function handle(GetResponseEvent $event)
    {
        try {
            $token = new SkautisToken();
            $userDetail = $this->skautis->user->UserDetail();

            $username = $this->userConnector->getUsername($userDetail->ID_Person);
            $token->setUser($username);


            $authenticatedToken = $this->authenticationManager->authenticate($token);
            $this->tokenStorage->setToken($authenticatedToken);

        } catch (AuthenticationException $failed) {
            //@TODO Log error
        } catch (\Exception $e) {
            //@TODO log skautis error
        }

        //Anonymous authentication
    }

}
