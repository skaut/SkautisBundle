<?php

namespace SkautisBundle\Profiler;

use Skautis\Skautis;
use Skautis\SkautisQuery;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Sbira data o skautisu pro zobrazeni v profileru
 */
class SkautisDataCollector extends DataCollector
{

    /**
     * @var Skautis
     *
     * @method string app_id
     * @method bool test_mode
     * @method bool cache
     * @method bool compression
     * @method string role_id
     * @method string unit_id
     * @method string token
     * @method bool is_logged_in
     * @method \DateTime logout_date
     * @method bool maintenance
     */
    protected $skautis;

    public function __construct(Skautis $skautis)
    {
        $this->skautis = $skautis;
    }

    /**
     * @inheritdoc
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $config = $this->skautis->getConfig();
        $this->data = [
            'queries' => $this->skautis->getDebugLog(),
            'app_id' => $config->getAppId(),
            'test_mode' => $config->isTestMode(),
            'cache' => $config->getCache(),
            'compression' => $config->getCompression(),
            'role_id' => $this->skautis->getUser()->getRoleId(),
            'unit_id' => $this->skautis->getUser()->getUnitId(),
            'token' => $this->skautis->getUser()->getLoginId(),
            'is_logged_in' => $this->skautis->getUser()->isLoggedIn(),
            'logout_date' => $this->skautis->getUser()->getLogoutDate(),
            'maintenance' => $this->skautis->isMaintenance(),
        ];
    }

    public function __call($method, $args)
    {
        return $this->data["$method"];
    }

    /**
     * Ziska vsechny SkautisQuery
     * @return SkautisQuery[]
     */
    public function getRequests()
    {
        return $this->data['queries'];
    }

    /**
     * Pocet requestu
     * @return int
     */
    public function getRequestCount()
    {
        return count($this->data['queries']);
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

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'skautis_collector';
    }
}
