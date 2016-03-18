<?php

namespace SkautisBundle\Security\Authentication\Connector;

/**
 * Interface pro propojeni Symfony uzivatele a Skautis uzivatele
 */
interface UserConnectorInterface
{
    /**
     * Ziska jmeno symfony uzivatele ktery je propojen s danym $personId
     *
     * @param int $personId
     * @return string username symfony uzivatele
     */
    public function getUsername($personId);

    /**
     * Ziska $personId skautis uzivatele ktery je propojen se symfony uzivatelem
     *
     * @param string $userName symfony uzivatele
     * @return int
     */
    public function getPersonId($userName);

    /**
     * Propoji symfony uzivatele se skautis uzivatelem
     *
     * @param int $personId Skautis personId
     * @param string $username Symfony user
     * @return void
     */
    public function connect($personId, $username);

    /**
     * Rozpoji uzivatele podle Symfony $username
     *
     * @param string $username Symfony user
     * @return void
     */
    public function disconnect($username);
}
