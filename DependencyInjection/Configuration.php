<?php

namespace SkautisBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('skautis');

        $rootNode->children()
            ->scalarNode('app_id')
            ->isRequired()
            ->info("Skautis app id")
            ->end()
            ->booleanNode('test_mode')
            ->defaultValue(true)
            ->isRequired()
            ->info("Use test-is.skaut.cz")
            ->end()
            ->booleanNode('profiler')
            ->defaultValue('%kernel.debug%')
            ->info("Gather data for profiler")
            ->end()
            ->booleanNode('wsdl_compression')
            ->defaultValue(true)
            ->info("Enable WSDL compression")
            ->end()
            ->booleanNode('wsdl_cache')
            ->defaultValue(false)
            ->info("Enable wsdl cache")
            ->end()
            ->scalarNode('doctrine_cache_provider')
            ->defaultValue('')
            ->info("Doctrine cache provider")
            ->end()
            ->booleanNode('request_cache')
            ->defaultValue(false)
            ->info("Use request cache")
            ->end()
            ->integerNode('request_cache_ttl')
            ->defaultValue(0)
            ->info("Request cache time to live")
            ->end()
            ->scalarNode('after_login_redirect')
            ->defaultValue('homepage')
            ->info("Route to be redirected to after login")
            ->end()
            ->scalarNode('after_logout_redirect')
            ->defaultValue('homepage')
            ->info("Route to be redirected to after logout")
            ->end()
            ->arrayNode("auth")->children()
            ->booleanNode("enable_connector")
            ->info("Enable connecting users from Skautis to Users in application")
            ->defaultValue(false)
            ->end()
            ->scalarNode('connector_service')
            ->defaultValue('')
            ->info("Name of service implementing UserConnectorInterface")
            ->end()
            ->booleanNode("enable_autoregister")
            ->defaultValue(false)
            ->info("Enable automatic registering of users from SkautIS")
            ->end()
            ->scalarNode('registrator_service')
            ->defaultValue('')
            ->info("Name of service implementing UserRegistratorInterface")
            ->end()
            ->booleanNode("enable_skautis_anonymous")
            ->defaultValue(false)
            ->info("Login users to Symfony who has account at Skautis only")
            ->end()
            ->booleanNode("force_confirm_auth")
            ->defaultValue(true)
            ->info("Verify login via request to SkautIS server on each access")
            ->end()
            ->end();

        return $treeBuilder;
    }
}
