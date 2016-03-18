<?php

namespace SkautisBundle\Security\Authentication\Connector;

use Doctrine\ORM\EntityManager;
use SkautisBundle\Entity\DoctrineUserConnection;
use SkautisBundle\Security\Authentication\Connector\SkautisUserConnectorInterface;

/**
 * Trida pro propojeni symfony uzivatele se Skautis uzivatelem, ukladajici data pomoci Doctrine ORM
 */
class DoctrineUserConnector implements SkautisUserConnectorInterface
{

    /**
     * @var EntityManager
     */
    protected $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    /**
     * @inheritdoc
     */
    public function getUsername($personId) {
        /**
         * @var DoctrineUserConnection
         */
        $connection = $this->em->find('SkautisBundle\Entity\DoctrineUserConnection', $personId);

        if (!$connection) {
            return "";
        }

        return $connection->getUsername();
    }

    /**
     * @inheritdoc
     */
    public function getPersonId($username) {
        $connection = $this->findConnectionByUsername($username);

        if (!$connection) {
            return "";
        }

        return $connection->getUsername();
    }

    /**
     * @inheritdoc
     */
    public function connect($personId, $username) {

        $queryBuilder = $this->em->createQueryBuilder()
            ->select('C')
            ->from('SkautisBundle\Entity\DoctrineUserConnection', 'C')
            ->where('C.username = :username')
            ->orWhere('C.personId = :person_id')
            ->setParameter('username', $username)
            ->setParameter('person_id', $personId);

        $result = $queryBuilder->getQuery()->getResult();

        if (sizeof($result) > 0) {
            return; //@TODO exception?
        }


        $connection = new DoctrineUserConnection();
        $connection->setPersonId($personId);
        $connection->setUsername($username);
        $this->em->persist($connection);
        $this->em->flush();
    }

    /**
     * @inheritdoc
     */
    public function disconnect($username) {
        $connection = $this->findConnectionByUsername($username);

        if (!$connection) {
            return; //@TODO exception?
        }

        $this->em->remove($connection);
        $this->em->flush();
    }

    /**
     * @param string $username
     * @return DoctrineUserConnection|null
     */
    protected function findConnectionByUsername($username) {
        $queryBuilder = $this->em->createQueryBuilder()
            ->select('C')
            ->from('SkautisBundle\Entity\DoctrineUserConnection', 'C')
            ->where('C.username = :username')
            ->setParameter('username', $username);

        $result = $queryBuilder->getQuery()->getResult();

        if (sizeof($result) < 1) {
            return null;
        }

        return $result[0];
    }
}
