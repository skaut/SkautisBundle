<?php

namespace SkautisBundle\DependencyInjection\Security\Factory;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\SecurityFactoryInterface;
use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\AbstractFactory;

class SkautisFactory implements SecurityFactoryInterface
{

    /**
     * @inheritDoc
     */
    public function addConfiguration(NodeDefinition $node)
    {

    }

    /**
     * @inheritDoc
     */
    public function create(ContainerBuilder $container, $id, $config, $userProvider, $defaultEntryPoint)
    {
        $providerId = 'skautis.security.authentication.provider.'.$id;
        $container
            ->setDefinition($providerId, new DefinitionDecorator('skautis.security.authentication.provider'))
            ->replaceArgument(0, new Reference($userProvider));

        $listenerId = 'skautis.security.authentication.listener.'.$id;
        $container->setDefinition($listenerId, new DefinitionDecorator('skautis.security.authentication.listener'));

        return array($providerId, $listenerId, "skautis.security_authentication.skautis_entry_point");
    }


    /**
     * @inheritDoc
     */
    public function getPosition()
    {
        return 'pre_auth';
    }

    /**
     * @inheritDoc
     */
    public function getKey()
    {
        return 'skautis';
    }
}
