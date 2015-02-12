<?php

namespace SkautisBundle\Skautis\Wsdl;

use Skautis\Wsdl\WebService;
use Symfony\Component\Stopwatch\Stopwatch;

class StopwatchWebService extends WebService
{

   /**
     * Profilovani
     *
     * @var Stopwatch
     */
    protected $stopwatch;

    /**
     * @var int[]
     */
    protected $counter = [];

    public function setStopwatch(Stopwatch $stopwatch)
    {
        $this->stopwatch = $stopwatch;
    }

    protected function getWatchName($function_name)
    {
        $name = $function_name;

	if (isset($this->counter[$function_name])) {
            $name .= ' - ' . $this->counter[$function_name];
            $this->counter[$function_name]++;
        }
        else {
	    $this->counter[$function_name] = 0;
	}

	return $name;
    }

    /**
     * @inheritdoc
     */
    public function __call($function_name, $arguments)
    {
        return $this->call($function_name, $arguments);
    }

    /**
     * @inheritdoc
     */
    public function call($function_name, array $arguments = [])
    {
        $name = $this->getWatchName($function_name);
	$this->stopwatch->start($name, "skautis");

	try {
            $result = parent::call($function_name, $arguments);
	}
	catch (\Exception $e) {
	    throw $e;
	}
	finally {
	    $this->stopwatch->stop($name);
	}

	return $result;
    }

}
