<?php

namespace SkautisBundle\Security\Core\Role;

use Symfony\Component\Security\Core\Role\RoleInterface;

/**
 * Class indicating user has his account connected with his Skautis profilez
 * @package SkautisBundle\Security\Core\Role
 */
class SkautisRole implements RoleInterface
{
    /**
     * @inheritdoc
     */
    public function getRole()
    {
        return 'ROLE_SKAUTIS';
    }


}
