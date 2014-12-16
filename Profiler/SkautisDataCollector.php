<?php

namespace SkautisBundle\Profiler;

use Skautis\Skautis;
use Skatis\SkautisQuery;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class SkautisDataCollector extends DataCollector
{

    /**
     * @var Skautis
     */
    protected $skautis;

    public function __construct(Skautis $skautis)
    {
        $this->skautis = $skautis;
    }

    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
	$config = $this->skautis->getConfig();
        $this->data = array(
    	    'queries'           => $this->skautis->log,
            'app_id'            => $config->getAppId(),
	    'test_mode'         => $config->getTestMode(),
	    'profiling_enabled' => $config->getProfiler(),
	    'cache'             => $config->getCache(),
	    'compression'       => $config->getCompression(),
	    'role_id'           => $this->skautis->getRoleId(),
	    'unit_id'           => $this->skautis->getUnitId(),
	    'token'             => $this->skautis->getLoginId(),
	    'is_logged_in'      => $this->skautis->isLoggedIn(),
	    'logout_date'       => $this->skautis->getLogoutDate(),
	    'maintenance'       => $this->skautis->isMaintenance(),
        );
    }

    public function __call($method, $args)
    {
        return $this->data["$method"];
    }

    public function getRequests()
    {
	return $this->data['queries'];
    }

    /**
     * @return int Miliseconds
     */
    public function getTotalTime()
    {
       $totalTime = 0;
	foreach ($this->data['queries'] as $query) {
            $totalTime += $query->time;
	}

	return $totalTime * 1000;
    }

    public function getRequestCount()
    {
	return count($this->data['queries']);
    }

    public function getName()
    {
        return 'skautis_collector';
    }
}
