<?php

namespace SkautisBundle\Security\Authentication\Connector;

use Doctrine\ORM\EntityManager;
use SkautisBundle\Entity\DoctrineUserConnection;
use SkautisBundle\Exception\UserConnectionNotFound;
use SkautisBundle\Exception\UserNotFound;
use SkautisBundle\Security\Authentication\Connector\UserConnectorInterface;

/**
 * Trida pro propojeni symfony uzivatele se Skautis uzivatelem, ukladajici data pomoci Doctrine ORM
 */
class DoctrineUserConnector implements UserConnectorInterface
{

    /**
     * @var EntityManager
     */
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @inheritdoc
     */
    public function getUsername($personId)
    {
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
    public function getPersonId($username)
    {
        $connection = $this->findConnectionByUsername($username);

        if (!$connection) {
            return "";
        }

        return $connection->getUsername();
    }

    /**
     * @inheritdoc
     */
    public function connect($personId, $username)
    {

        $queryBuilder = $this->em->createQueryBuilder()
            ->select('C')
            ->from('SkautisBundle\Entity\DoctrineUserConnection', 'C')
            ->where('C.username = :username')
            ->orWhere('C.personId = :person_id')
            ->setParameter('username', $username)
            ->setParameter('person_id', $personId);

        $result = $queryBuilder->getQuery()->getResult();

        if (sizeof($result) > 0) {
            throw new UserNotFound("User cannot be connected because user '$username' does not exist!");
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
    public function disconnect($username)
    {
        $connection = $this->findConnectionByUsername($username);

        if (!$connection) {
            throw new UserConnectionNotFound("User '$username'' cannot be disconnected because he is not connected!");
        }

        $this->em->remove($connection);
        $this->em->flush();
    }

    /**
     * @param string $username
     * @return DoctrineUserConnection|null
     */
    protected function findConnectionByUsername($username)
    {
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
