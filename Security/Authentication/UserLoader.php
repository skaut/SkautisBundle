<?php

namespace SkautisBundle\Security\Authentication;


use SkautisBundle\Security\Authentication\Connector\UserConnectorInterface;
use SkautisBundle\Security\Authentication\Registrator\UserRegistratorInterface;

class UserLoader
{
    /**
     * @var bool
     */
    private $enableConnector ;
    /**
     * @var UserConnectorInterface
     */
    private $userConnector;

    /**
     * @var bool
     */
    private $enableAutoRegister;

    /**
     * @var UserRegistratorInterface
     */
    private $userRegistrator;

    /**
     * UserLoader constructor.
     * @param bool $enableConnector
     * @param UserConnectorInterface $userConnector
     * @param bool $enableAutoRegister
     * @param UserRegistratorInterface $userRegistrator
     */
    public function __construct($enableConnector = false, UserConnectorInterface $userConnector = null, $enableAutoRegister = false, UserRegistratorInterface $userRegistrator = null)
    {
        $this->enableConnector = $enableConnector;
        $this->userConnector = $userConnector;
        $this->enableAutoRegister = $enableAutoRegister;
        $this->userRegistrator = $userRegistrator;
    }


    public function loadUser($personId, $userProvider)
    {
        if (!$this->enableConnector) {
            return null;
        }

        if (!$this->userConnector) {
            throw new \Exception("No userConnector set while autoregistration enabled"); //@TODO custom exception
        }

        $user = null;
        $username = $this->userConnector->getUsername($personId);
        if (!empty($username)) {
            return $userProvider->loadUserByUsername($username);
        }


        if (!$this->enableAutoRegister) {
            return null;
        }

        if (!$this->userRegistrator) {
            throw new \Exception("No registrator set while autoregistration enabled"); //@TODO custom exception
        }

        $username = $this->userRegistrator->registerUser();  //@TODO log registration
        $this->userConnector->connect($personId, $username);

        return $userProvider->loadUserByUsername($username);
    }
}