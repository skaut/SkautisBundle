<?php

namespace SkautisBundle\Security\Authentication;

use SkautisBundle\Security\Core\Role\SkautisRole;
use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class SkautisProvider implements AuthenticationProviderInterface
{
    private $userProvider;
    private $cacheDir;
    private $userRegistrator;
    private $userConnector;
    private $enableAutoRegister = true;


    public function __construct(UserProviderInterface $userProvider, $cacheDir, UserRegistratorInterface $userRegistrator, SkautisUserConnectorInterface $userConnector)
    {
        $this->userProvider = $userProvider;
        $this->cacheDir     = $cacheDir;
        $this->userRegistrator = $userRegistrator;
        $this->userConnector = $userConnector;
    }


    /**
     * @inheritdoc
     */
    public function authenticate(TokenInterface $token)
    {

        /**
         * @var $token SkautisToken
         */

        $user = null;
        try {
            $username = $this->userConnector->getUsername($token->getPersonId());
            $user = $this->userProvider->loadUserByUsername($username);
        }
        catch (\Exception $e) {
            //@TODO kdyz ne autoregistrace tak throw znova?
        }


        if (!$user && $this->enableAutoRegister) {
            $username = $this->userRegistrator->registerUser();
            $this->userConnector->connect($token->getPersonId(), $username);
            //@TODO log registration

            $user = $this->userProvider->loadUserByUsername($username);
        }

        if (!$user) {
            throw new AuthenticationException('The Skautis authentication failed.');
        }

        $roles = array_merge($user->getRoles(), [new SkautisRole()]);
        $authenticatedToken = new SkautisToken($roles);
        $authenticatedToken->setUser($user);
        $authenticatedToken->setAuthenticated(true);

        return $authenticatedToken;
    }


    /**
     * @inheritdoc
     */
    public function supports(TokenInterface $token)
    {
        return $token instanceof SkautisToken;
    }
}
