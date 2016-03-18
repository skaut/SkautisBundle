<?php

namespace SkautisBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Reference;

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
        $container->setParameter('skautis.wsdl.compression', $config['wsdl_compression']);
        $container->setParameter('skautis.wsdl.cache', $config['wsdl_cache']);
        $container->setParameter('skautis.doctrine.cache.ttl', $config['request_cache_ttl']);
        $container->setParameter('skautis.after_login_redirect', $config['after_login_redirect']);
        $container->setParameter('skautis.after_logout_redirect', $config['after_logout_redirect']);
        $container->setParameter('skautis.auth.enable_connector', $config['auth']['enable_connector']);
        $container->setParameter('skautis.auth.enable_autoregister', $config['auth']['enable_autoregister']);
        $container->setParameter('skautis.auth.enable_skautis_anonymous', $config['auth']['enable_skautis_anonymous']);
        $container->setParameter('skautis.auth.force_confirm_auth', $config['auth']['force_confirm_auth']);

        if ($config['auth']['enable_connector']) {
            $container->setAlias("skautis.security.authentication.connector", $config['connector_service']);
        }

        if ($config['auth']['enable_autoregister']) {
            $container->setAlias("skautis.security.authentication.connector", $config['registrator_service']);
        }


        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        if ($config['request_cache']) {

            $container->register('skautis.doctrine.cache', '%skautis.cache_class%')
                ->addArgument(new Reference($config['doctrine_cache_provider']))
                ->addArgument('skautis.doctrine.cache.ttl');

            $container->register('skautis.ws_cache_factory', 'SkautisBundle\Skautis\Wsdl\CacheDecoratorFactory')
                ->addArgument(new Reference('skautis.ws_cache_factory.inner'))
                ->addArgument(new Reference('skautis.doctrine.cache'))
                ->setDecoratedService('skautis.ws_factory')
                ->setPublic(false);
        }
    }
}

