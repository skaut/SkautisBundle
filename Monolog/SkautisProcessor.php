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


    protected $user;

    public function __construct(Skautis $skautis)
    {
        $this->skautis = $skautis;
    }

    public function processRecord(array $record)
    {

        if ($this->user == "NONE") {
            $this->user = $this->skautis->user->UserDetail();
        }

        $data = [
            'uid' => isset($this->user['ID']) ? $this->user['ID'] : "NONE",
        ];

        $record['extra']['skautis'] = $data;
        return $record;
    }
}
