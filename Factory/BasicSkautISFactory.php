<?php

/**
 * Factory class for SkautIS
 *
 * @author Jindrich Pilar <pilar.jindrich@gmail.com>
 */

namespace SkautisBundle\Factory;

use SkautIS\SkautIS;
use SkautIS\Factory\WSFactory;
use SkautIS\SessionAdapter\AdapterInterface;

/**
 * This class is used to create SkautIS objects
 */
class BasicSkautISFactory extends SkautISFactory
{


    /**
     * @inheritdoc
     */
    public function get($appId, $testMode, $profiler, $compression, AdapterInterface $sessionAdapter, WSFactory $wsFactory)
    {
        $skautIS = SkautIS::getInstance($appId, $testMode, $profiler, $sessionAdapter, $wsFactory);
        $skautIS->setCompression($compression);

	return $skautIS;
    }
}
