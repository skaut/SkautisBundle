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
	    ->end()
            ->booleanNode('test_mode')
		->defaultValue(true)
		->isRequired()
	    ->end()
	    ->booleanNode('profiler')
		->defaultValue('%kernel.debug%')
	    ->end()
	    ->booleanNode('compression')
                ->defaultValue(true)
	    ->end()
	    ->booleanNode('wsdl_cache')
		->defaultValue(false)
	    ->end()
            ->scalarNode('doctrine_cache_provider')
                ->defaultValue('')
            ->end()
	    ->booleanNode('request_cache')
                ->defaultValue(false)
            ->end()
            ->integerNode('request_cache_ttl')
                ->defaultValue(0)
            ->end()
	    ->scalarNode('after_login_redirect')
                ->defaultValue('homepage')
	    ->end()
	    ->scalarNode('after_logout_redirect')
                ->defaultValue('homepage')
	    ->end();

        return $treeBuilder;
    }
}
