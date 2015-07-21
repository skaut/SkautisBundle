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
        ->end();

        return $treeBuilder;
    }
}
