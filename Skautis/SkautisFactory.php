<?php

namespace SkautisBundle\Skautis;

use Skautis\Skautis;
use Skautis\Wsdl\WsdlManager;
use Skautis\User;

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
    public function createSkautis(WsdlManager $wsdlManager, User $user, $debug)
    {
        $skautis = new Skautis($wsdlManager, $user);

	if ($debug) {
            $skautis->enableDebugLog();
	}

	return $skautis;
    }
}
