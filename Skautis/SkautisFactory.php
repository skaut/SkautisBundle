<?php

namespace SkautisBundle\Skautis;

use Skautis\Skautis;
use Skautis\Wsdl\WsdlManager;
use Skautis\SessionAdapter\AdapterInterface;

class SkautisFactory
{
   /**
     * Vytvari objek skautisu a vola nastaveni
     *
     * @param WsdlManager      $wsdlManager
     * @param AdapterInterface $sessionAdapter
     * @param bool             $debug
     *
     * @return Skautis
     */
    public function createSkautis(WsdlManager $wsdlManager, AdapterInterface $sessionAdapter, $debug)
    {
        $skautis = new Skautis($wsdlManager, $sessionAdapter);

	if ($debug) {
            $skautis->enableDebugLog();
	}

	return $skautis;
    }
}
