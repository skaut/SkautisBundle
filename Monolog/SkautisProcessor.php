<?php

namespace SkautisBundle\Monolog;

use Skautis\Skautis;

/**
 * Pridava Skautis informace k zaznamu v logu
 */
class SkautisProcessor
{

    /**
     * @var Skautis
     */
    protected $skautis;

    /**
     * @var \stdClass
     */
    protected $user;

    public function __construct(Skautis $skautis)
    {
        $this->skautis = $skautis;
    }

    /**
     * Prida informace k logu
     *
     * @param array $record
     * @return array
     */
    public function processRecord(array $record)
    {

        if (!$this->user) {
            $this->user = $this->skautis->user->UserDetail();
        }

        $data = [
            'uid' => isset($this->user->ID) ? $this->user->ID : "NONE",
        ];

        $record['extra']['skautis'] = $data;
        return $record;
    }
}
