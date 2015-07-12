<?php

namespace SkautisBundle\Security\Authentication;

interface SkautisUserConnectorInterface
{
    public function getUsername($personId);

    public function getPersonId($userName);

    public function connect($personId, $username);

    public function disconnect($username);
}
