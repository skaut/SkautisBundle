<?php

namespace SkautisBundle\Security\Authentication;

use Skautis\Skautis;
use SkautisBundle\Security\Core\Role\SkautisRole;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class SkautisAuthenticator
 * GuardAuthenticator explained https://symfony.com/doc/master/cookbook/security/guard-authentication.html
 */
class SkautisAuthenticator extends  AbstractGuardAuthenticator //implements GuardAuthenticatorInterface
{
    const SKAUTIS_LOGIN_ID = "skautis_login_id";
    const SKAUTIS_PERSON_ID = "skautis_person_id";

    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @var Skautis
     */
    protected $skautis;

    /**
     * @var Session
     */
    protected $session;

    /**
     * @var UserLoader
     */
    protected $userLoader;

    /**
     * @var bool
     */
    protected $confirm;

    /**
     * @var bool
     */
    protected $anonymousSkautLogin;

    /**
     * SkautisAuthenticator constructor.
     * @param Skautis $skautis
     * @param RouterInterface $router
     * @param Session $session
     * @param UserLoader $userLoader
     * @param bool $confirm
     * @param bool $anonymousSkautLogin
     */
    public function __construct(Skautis $skautis, RouterInterface $router, Session $session, UserLoader $userLoader, $confirm = true, $anonymousSkautLogin = false)
    {
        $this->skautis = $skautis;
        $this->router = $router;
        $this->session = $session;
        $this->userLoader = $userLoader;
        $this->confirm = $confirm;
        $this->anonymousSkautLogin = $anonymousSkautLogin;
    }

    /**
     * @inheritdoc
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new RedirectResponse($this->router->generate("skautis_login"));
    }

    /**
     * @inheritdoc
     */
    public function getCredentials(Request $request)
    {
        if (!$this->skautis->getUser()->isLoggedIn($this->confirm)) {
            return null;
        }

        //Kontrola ze uzivatel prihlaseny do skautisu je stejny jako uzivatel prihlaseny do symfony
        $loginId = $this->skautis->getUser()->getLoginId();
        if ($loginId != $this->session->get(self::SKAUTIS_LOGIN_ID)) {
            $userDetail = $this->skautis->user->UserDetail();
            $personId = $userDetail->ID_Person;

            $this->session->set(self::SKAUTIS_LOGIN_ID, $loginId);
            $this->session->set(self::SKAUTIS_PERSON_ID, $personId);
        }
        else {
            $personId = $this->session->get(self::SKAUTIS_PERSON_ID);
        }

        return [
            "person_id" => $personId,
        ];
    }

    /**
     * @inheritdoc
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $user = $this->userLoader->loadUser($credentials['person_id'], $userProvider);

        if (!$user && $this->anonymousSkautLogin) {
            //@TODO cache?
            $userDetail = $this->skautis->user->UserDetail();
            $user = new User(
                $userDetail->UserName,
                "NOPASSS", //@TODO random
                [new SkautisRole()]
            );
        }

        return $user;
    }

    /**
     * @inheritdoc
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        //Nic, getCredentials bere udaje ze $skautis
        return true;
    }

    /**
     * @inheritdoc
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function supportsRememberMe()
    {
        return false;
    }

    /**
     * @param boolean $confirm
     */
    public function setConfirm($confirm)
    {
        //@TODO constructor?
        $this->confirm = $confirm;
    }
}