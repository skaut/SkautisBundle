<?php

/**
 * AbstractFactory for SkautIS
 *
 * @author Jindrich Pilar <pilar.jindrich@gmail.com>
 */

namespace SkautisBundle\Factory;

use SkautIS\SkautIS;
use SkautIS\Factory\WSFactory;
use SkautIS\SessionAdapter\AdapterInterface;

/**
 * Class for creating skautis
 */
abstract class SkautISFactory
{


	/**
	 * Set common data
	 *
	 * @param bool             $appId          SkautIS application ID
	 * @param bool             $testMode       Indicates whether to use SkautIS in testing mode
	 * @param bool             $profiler       Indicates whether to use profiler
	 * @param bool             $compression    Indicates whether to use compression
	 * @param AdapterInterface $sessionAdapter Symfony Session adapter
	 * @param WSFactory        $wsFactory      Object used to create WS
	 *
	 * @return SkautIS
	 */
        abstract public function get($appId, $testMode, $profiler, $compression, AdapterInterface $sessionAdapter, WSFactory $wsFactory);

}
