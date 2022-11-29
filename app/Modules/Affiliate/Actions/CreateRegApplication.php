<?php

namespace App\Modules\Affiliate\Actions;

use App\Modules\Affiliate\Managers\ProfileManager;
use App\Modules\Affiliate\Managers\RegApplicationManager;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class CreateRegApplication
{
    /**
     * @var array
     */
    private $data;

    /**
     * CreateRegApplication constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @throws \Throwable
     */
    public function run()
    {
        try {
            DB::beginTransaction();

            $profile_data = Arr::only($this->data, ['name', 'email', 'is_tmf_customer']);
            $text = $this->data['text'] ?? null;

            $profile = ProfileManager::createProfile($profile_data);
            $application = RegApplicationManager::createRegApplication($profile, $text);

            DB::commit();

            return $application;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
