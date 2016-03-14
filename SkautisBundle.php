<?php

namespace SkautisBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use SkautisBundle\DependencyInjection\Security\Factory\SkautisFactory;

class SkautisBundle extends Bundle
{

    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $extension = $container->getExtension('security');
        $extension->addSecurityListenerFactory(new SkautisFactory());
    }
}
