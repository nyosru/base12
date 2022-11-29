<?php

namespace App\Modules\Affiliate\Actions;

use App\Modules\Affiliate\Managers\RegApplicationManager;
use App\Modules\Affiliate\Models\RegApplication;

class UpdateRegApplicationStatus
{
    /**
     * @var
     */
    private $application;

    /**
     * @var int
     */
    private $status;

    /**
     * UpdateRegApplicationStatus constructor.
     * @param RegApplication $application
     * @param int $status
     */
    public function __construct(RegApplication $application, int $status)
    {
        $this->application = $application;
        $this->status = $status;
    }

    /**
     * @return bool
     */
    public function run()
    {
        return RegApplicationManager::updateRegApplicationStatus($this->application, $this->status);
    }
}
