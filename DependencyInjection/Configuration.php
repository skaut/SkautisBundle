<?php

namespace SkautisBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
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
	    ->end();



        return $treeBuilder;
    }
}
