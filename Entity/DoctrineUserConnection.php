<?php

namespace SkautisBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entita pro ukladani propojeni symfony uzivatele se Skautis uzivatelem
 *
 * @ORM\Entity
 * @ORM\Table(name="skautis_user_connections")
 */
class DoctrineUserConnection
{

    /**
     * Person ID uzivatele Skautisu
     *
     * @ORM\Id
     * @ORM\Column(type="integer", unique=true, name="skautis_person_id")
     * @var int
     */
    protected $personId;

    /**
     * Username symfony uzivatele ktery je propojen se skautisem
     *
     * @ORM\Column(type="string", unique=true, name="username")
     * @var string
     */
    protected $username;

    /**
     * @param int $id
     */
    public function setPersonId($id)
    {
        $this->personId = $id;
    }

    /**
     * @return int
     */
    public function getPersonId()
    {
        return $this->personId;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }
}
