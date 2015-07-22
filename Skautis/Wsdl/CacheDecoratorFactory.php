<?php

namespace SkautisBundle\Skautis\Wsdl;

use Skautis\Wsdl\WebServiceFactoryInterface;
use Skautis\Wsdl\Decorator\Cache\CacheInterface;
use Skautis\Wsdl\Decorator\Cache\CacheDecorator;

/**
 * Trida pro pridavani cache decoratur na web service
 */
class CacheDecoratorFactory implements WebServiceFactoryInterface
{
    /**
     * @var WebServiceFactoryInterface
     */
    protected $webServiceFactory;

    /**
     * @var CacheInterface
     */
    protected $cache;

    public function __construct(WebServiceFactoryInterface $webServiceFactory, CacheInterface $cache)
    {
        $this->serviceFactory = $webServiceFactory;
        $this->cache = $cache;
    }

    public function createWebService($url, array $options)
    {
        $webService = $this->serviceFactory->createWebService($url, $options);
        $webService = new CacheDecorator($webService, $this->cache);

        return $webService;
    }
}
