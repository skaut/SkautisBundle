<?php

namespace SkautisBundle\Skautis\Wsdl;

use Skautis\Wsdl\WebServiceFactory;
use Symfony\Component\Stopwatch\Stopwatch;

class StopwatchWebServiceFactory extends WebServiceFactory
{

   /**
    * Profilovani
    *
    * @var Stopwatch
    */
   protected $stopwatch = null;

   /**
    * Nastavi objekt pro profilovani
    *
    * @param Stopwatch $stopwatch Idealne ziskany z DIC
    */
   public function setStopwatch(Stopwatch $stopwatch)
   {
       $this->stopwatch = $stopwatch;
   }

   /**
    * @inheritdoc
    */
    public function createWebService($wsdl, array $init)
    {
        $ws = new $this->class($wsdl, $init);

	if ($this->stopwatch !== null) {
	    $ws->setStopwatch($this->stopwatch);
	}

        return $ws;
    }

}
