<?php

namespace SkautisBundle\Tests\Integration;

use SkautisBundle\Tests\Integration\KernelAwareTest;

class ServiceTest extends KernelAwareTest
{
    public function testSkautisService()
    {
        $skautIS = $this->container->get('skautis');

	$loginUrl = $skautIS->getLoginUrl();

	$this->assertContains('http://', $loginUrl);
    }
}
