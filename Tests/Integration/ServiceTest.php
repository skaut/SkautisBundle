<?php

namespace SkautisBundle\Tests\Integration;


class ServiceTest extends KernelAwareTest
{
    public function testSkautisService()
    {
        $skautIS = $this->container->get('skautis');

        $loginUrl = $skautIS->getLoginUrl();

        $this->assertContains('http://', $loginUrl);
    }
}
