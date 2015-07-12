<?php

namespace SkautisBundle\Security\Authentication;

use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\NonceExpiredException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Util\StringUtils;
use SkautisBundle\Security\Authentication\SkautisToken;

class SkautisProvider implements AuthenticationProviderInterface
{
    private $userProvider;
    private $cacheDir;

    public function __construct(UserProviderInterface $userProvider, $cacheDir)
    {
        $this->userProvider = $userProvider;
        $this->cacheDir     = $cacheDir;
    }


    /**
     * @inheritdoc
     */
    public function authenticate(TokenInterface $token)
    {
        $user = $this->userProvider->loadUserByUsername($token->getUsername());

        if (!$user) {
            throw new AuthenticationException('The Skautis authentication failed.');
        }

        $roles = array_merge($user->getRoles(), ["SKAUTIS_USER"]);
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
