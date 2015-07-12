<?php

namespace SkautisBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="skautis_user_connections")
 */
class DoctrineUserConnection {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", unique=true, name="skautis_person_id")
     * @var int
     */
    protected $personId;

    /**
     * @ORM\Column(type="string", unique=true, name="username")
     * @var string
     */
    protected $username;

    public function setPersonId($id) {
        $this->personId = $id;
    }

    public function getPersonId() {
        return $this->personId;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getUsername() {
        return $this->username;
    }
}
