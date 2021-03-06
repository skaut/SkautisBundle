<?php

namespace SkautisBundle\Skautis;

use Skautis\SessionAdapter\AdapterInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Adapter pro pouziti Symfony Session ve Skautisu
 */
class SessionAdapter implements AdapterInterface
{

    /**
     * @var SessionInterface
     */
    protected $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @inheritdoc
     */
    public function set($name, $object)
    {
        $this->session->set($name, $object);
    }

    /**
     * @inheritdoc
     */
    public function has($name)
    {
        return $this->session->has($name);
    }


    /**
     * @inheritdoc
     */
    public function get($name)
    {
        return $this->session->get($name);
    }
}
