<?php

namespace App\Modules\Affiliate\Managers;

use App\Modules\Affiliate\Models\Profile;
use App\Modules\Affiliate\Models\RegApplication;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class RegApplicationManager
{
    /**
     * @param Profile $profile
     * @param string $text
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     * @throws \Exception
     */
    public static function createRegApplication(Profile $profile, string $text)
    {
        if ($profile->trashed()) {
            throw new ConflictHttpException('You are trying to create registration request for removed profile');
        }

        $data['aff_profile_id'] = $profile->id;
        $data['text'] = $text;

        $application = RegApplication::query()->create($data);

        if (!$application instanceof RegApplication) {
            throw new \Exception('Failed to created registration application');
        }

        return $application;
    }

    /**
     * @param RegApplication $application
     * @param int $status
     * @return bool
     */
    public static function updateRegApplicationStatus(RegApplication $application, int $status)
    {
        if (!in_array($status, RegApplication::$statuses)) {
            throw new \InvalidArgumentException('Status is out of range');
        }

        if ($status == $application->status) {
            return false;
        }

        return $application->update(['status' => $status]);
    }
}
