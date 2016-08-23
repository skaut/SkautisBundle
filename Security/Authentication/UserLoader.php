<?php

namespace SkautisBundle\Security\Authentication;


use SkautisBundle\Exception\ConfigurationException;
use SkautisBundle\Security\Authentication\Connector\UserConnectorInterface;
use SkautisBundle\Security\Authentication\Registrator\UserRegistratorInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 *  Facade class responsible for user management.
 */
class UserLoader
{
    /**
     * @var bool
     */
    private $enableConnector;
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


    /**
     * Loads user based on $personId
     *
     * @param string $personId Id of person from Skautis
     * @param UserProviderInterface $userProvider
     * @return null|\Symfony\Component\Security\Core\User\UserInterface
     * @throws ConfigurationException
     */
    public function loadUser($personId, UserProviderInterface $userProvider)
    {
        if (!$this->enableConnector) {
            return null;
        }

        if (!$this->userConnector) {
            throw new ConfigurationException("No userConnector set while autoregistration enabled");
        }

        $username = $this->userConnector->getUsername($personId);
        if (!empty($username)) {
            return $userProvider->loadUserByUsername($username);
        }


        if (!$this->enableAutoRegister) {
            return null;
        }

        if (!$this->userRegistrator) {
            throw new ConfigurationException("No registrator set while autoregistration enabled");
        }

        $username = $this->userRegistrator->registerUser();
        $this->userConnector->connect($personId, $username);

        return $userProvider->loadUserByUsername($username);
    }
}
