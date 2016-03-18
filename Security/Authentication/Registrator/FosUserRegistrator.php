<?php

namespace SkautisBundle\Security\Authentication\Registrator;


use Skautis\Skautis;
use FOS\UserBundle\Model\UserManager;
use SkautisBundle\Security\Authentication\Registrator\UserRegistratorInterface;
use Symfony\Component\Security\Core\Util\SecureRandom;

class FosUserRegistrator implements  UserRegistratorInterface
{
    const NUMBER_OF_RANDOM_BYTES = 10;

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
        $user->setPassword($this->generatePassword());
        $user->setEmail("email@email.cz");

        $this->userManager->updateUser($user);

        return $user->getUsername();
    }

    /**
     * Generate password for newly registered user
     * @return string
     */
    protected function generatePassword()
    {
        $generator = new SecureRandom();
        $randomBytes = $generator->nextBytes(self::NUMBER_OF_RANDOM_BYTES);

        return base64_encode($randomBytes);
    }

}
