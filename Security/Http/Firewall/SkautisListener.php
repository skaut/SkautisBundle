<?php

namespace SkautisBundle\Security\Http\Firewall;

use SkautisBundle\Security\Core\Authentication\Token\SkautisToken;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Firewall\ListenerInterface;
use Skautis\Skautis;
use Symfony\Component\HttpFoundation\Session\Session;

class SkautisListener implements ListenerInterface
{
    const SKAUTIS_LOGIN_ID = "skautis_login_id";
    const SKAUTIS_PERSON_ID = "skautis_person_id";

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
     * @var bool
     */
    protected $confirm = true;

    /**
     * @var Session
     */
    protected $session;

    /**
     * SkautisListener constructor.
     * @param TokenStorageInterface $tokenStorage
     * @param AuthenticationManagerInterface $authenticationManager
     * @param Skautis $skautis
     */
    public function __construct(TokenStorageInterface $tokenStorage, AuthenticationManagerInterface $authenticationManager, Skautis $skautis, Session $session)
    {
        $this->tokenStorage = $tokenStorage;
        $this->authenticationManager = $authenticationManager;
        $this->skautis = $skautis;
        $this->session = $session;
    }


    /**
     * @inheritdoc
     */
    public function handle(GetResponseEvent $event)
    {
        try {

            if (!$this->skautis->getUser()->isLoggedIn($this->confirm)) {
                return;
            }

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

            $token = new SkautisToken();
            $token->setPersonId($personId);

            $authenticatedToken = $this->authenticationManager->authenticate($token);
            $this->tokenStorage->setToken($authenticatedToken);

        } catch (AuthenticationException $failed) {
            //@TODO Log error
        } catch (\Skautis\Exception $e) {
            //@TODO log skautis error
        }

        //No exception to allow anonymous authentication
    }

    /**
     * @param boolean $confirm
     */
    public function setConfirm($confirm)
    {
        $this->confirm = $confirm;
    }


}
