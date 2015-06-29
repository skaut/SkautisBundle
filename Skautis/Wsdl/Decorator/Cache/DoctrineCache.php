<?php

namespace SkautisBundle\Skautis\Wsdl\Decorator\Cache;

use Skautis\Wsdl\Decorator\Cache\CacheInterface;
use Doctrine\Common\Cache\Cache;

class DoctrineCache implements CacheInterface
{

    /**
     * @var Cache
     */
    protected $doctrineCache;

    /**
     * @var int
     */
    protected $ttl;

    public function __construct(Cache $doctrineCache, $ttl = 0)
    {
        $this->doctrineCache = $doctrineCache;
        $this->ttl = $ttl;
    }

    /**
     * @inheritdoc
     */
    public function get($key)
    {
        $data = $this->doctrineCache->fetch($key);

        if ($data === false) {
            return null;
        }

        return $data;
    }

    /**
     * @inheritdoc
     */
    public function set($key, $value)
    {
        $this->doctrineCache->save($key, $value, $this->ttl);
    }
}
