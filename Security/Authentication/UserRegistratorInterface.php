<?php


namespace SkautisBundle\Security\Authentication;

/**
 * Registracni trida, pouzita pro autoregistraci
 */
interface UserRegistratorInterface
{
    /**
     * Register new symfony user
     *
     * @return string Username of newly registered user
     */
    public function registerUser();
}