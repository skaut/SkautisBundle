<?php

namespace SkautisBundle\Skautis;

use Skautis\Factory\BasicWSFactory;
use Symfony\Component\Stopwatch\Stopwatch;

class StopwatchWSFactory extends BasicWSFactory
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
    public function createWS($wsdl, array $init, $compression, $profiler)
    {
        $ws = new $this->class($wsdl, $init, $compression, $profiler);

	if ($this->stopwatch !== null) {
	    $ws->setStopwatch($this->stopwatch);
	}

        return $ws;
    }

}
