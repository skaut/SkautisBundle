<?php

namespace SkautisBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class SkautisExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
	$config = $this->processConfiguration($configuration, $configs);

	$container->setParameter('skautis.app_id', $config['app_id']);
	$container->setParameter('skautis.test_mode', $config['test_mode']);
	$container->setParameter('skautis.profiler', $config['profiler']);
	$container->setParameter('skautis.compression', $config['compression']);
	$container->setParameter('skautis.cache', $config['cache']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
