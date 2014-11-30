<?php

/**
 * Factory class for Skautis
 *
 * @author Jindrich Pilar <pilar.jindrich@gmail.com>
 */

namespace SkautisBundle\Factory;

use Skautis\Skautis;
use Skautis\Factory\WSFactory;
use Skautis\SessionAdapter\AdapterInterface;

/**
 * This class is used to create Skautis objects
 */
class BasicSkautisFactory extends SkautisFactory
{


    /**
     * @inheritdoc
     */
    public function get($appId, $testMode, $profiler, $compression, AdapterInterface $sessionAdapter, WSFactory $wsFactory)
    {
        $skautIS = Skautis::getInstance($appId, $testMode, $profiler, $sessionAdapter, $wsFactory);
        $skautIS->setCompression($compression);

	return $skautIS;
    }
}
