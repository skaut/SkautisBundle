<?php

namespace SkautisBundle\Security\Authentication;


use Skautis\Skautis;
use FOS\UserBundle\Model\UserManager;

class FosUserRegistrator implements  UserRegistratorInterface
{

    /**
     * @var Skautis
     */
    protected $skautis;

    /**
     * @var UserManager
     */
    protected $userManager;

    /**
     * DoctrineRegistrator constructor.
     * @param Skautis $skautis
     * @param UserManager $userManager
     */
    public function __construct(Skautis $skautis, UserManager $userManager)
    {
        $this->skautis = $skautis;
        $this->userManager = $userManager;
    }


    /**
     * @return string Username of newly registered user
     */
    public function registerUser()
    {
        $data = $this->skautis->user->UserDetail();

        $user = $this->userManager->createUser();
        $user->setEnabled(true);
        $user->setUsername($data->UserName);
        $user->setPassword("SKAUTIS-REGISTERED"); //@TODO some random
        $user->setEmail("email@email.cz");

        $this->userManager->updateUser($user);

        return $user->getUsername();
    }

}
