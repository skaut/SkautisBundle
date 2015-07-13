<?php


namespace SkautisBundle\Security\Authentication;


interface UserRegistratorInterface
{
    /**
     * @return string Username of newly registered user
     */
    public function registerUser();
}