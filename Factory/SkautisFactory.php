<?php

/**
 * AbstractFactory for Skautis
 *
 * @author Jindrich Pilar <pilar.jindrich@gmail.com>
 */

namespace SkautisBundle\Factory;

use Skautis\Skautis;
use Skautis\Factory\WSFactory;
use Skautis\SessionAdapter\AdapterInterface;

/**
 * Class for creating skautis
 */
abstract class SkautisFactory
{


	/**
	 * Set common data
	 *
	 * @param bool             $appId          Skautis application ID
	 * @param bool             $testMode       Indicates whether to use Skautis in testing mode
	 * @param bool             $profiler       Indicates whether to use profiler
	 * @param bool             $compression    Indicates whether to use compression
	 * @param AdapterInterface $sessionAdapter Symfony Session adapter
	 * @param WSFactory        $wsFactory      Object used to create WS
	 *
	 * @return Skautis
	 */
        abstract public function get($appId, $testMode, $profiler, $compression, AdapterInterface $sessionAdapter, WSFactory $wsFactory);

}
