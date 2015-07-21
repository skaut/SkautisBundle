<?php

namespace SkautisBundle\DependencyInjection\Security\Factory;

use Symfony\Component\Config\Definition\Builder\NodeBuilder;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\SecurityFactoryInterface;

class SkautisFactory implements SecurityFactoryInterface
{

    /**
     * @inheritDoc
     */
    public function addConfiguration(NodeDefinition $node)
    {
        /**
         * @var NodeBuilder $builder
         */
        $builder = $node->children();

        $builder
            ->booleanNode("autoregister")
                ->defaultFalse()
            ->end()
            ->booleanNode("confirm_auth")
                ->defaultTrue()
            ->end();
    }

    /**
     * @inheritDoc
     */
    public function create(ContainerBuilder $container, $id, $config, $userProvider, $defaultEntryPoint)
    {
        $providerId = 'skautis.security.authentication.provider.'.$id;
        $container
            ->setDefinition($providerId, new DefinitionDecorator('skautis.security.authentication.provider'))
            ->replaceArgument(0, new Reference($userProvider))
            ->replaceArgument(4, $config['autoregister']);

        $listenerId = 'skautis.security.authentication.listener.'.$id;
        $container->setDefinition($listenerId, new DefinitionDecorator('skautis.security.authentication.listener'))
            ->addMethodCall("setConfirm", [$config["confirm_auth"]]);



        $entrypointId = 'skautis.security_authentication.skautis_entry_point.'.$id;
        $container
            ->setDefinition($entrypointId, new DefinitionDecorator('skautis.security_authentication.skautis_entry_point'));

        return array($providerId, $listenerId, $entrypointId);
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
