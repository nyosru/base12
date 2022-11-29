<?php

namespace App\Modules\Affiliate\Managers;

use App\Modules\Affiliate\Models\Profile;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class ProfileManager
{
    /**
     * @param array $data
     * @return Profile
     * @throws \Exception
     */
    public static function createProfile(array $data)
    {
        $name = $data['name'] ?? null;

        if (!$name) {
            throw new \Exception('name is required for profile creation');
        }

        $email = $data['email'] ?? null;

        if (!$email) {
            throw new \Exception('email is required for profile creation');
        }

        $exists = Profile::query()->where('email', $email)->exists();

        if ($exists) {
            throw new ConflictHttpException("email $email has been taken already!");
        }

        $profile = Profile::query()->create($data);

        if (!$profile instanceof Profile) {
            throw new \Exception('Failed to create profile');
        }

        return $profile;
    }

    /**
     * @param Profile $profile
     * @return bool|null
     * @throws \Exception
     */
    public static function deleteProfile(Profile $profile)
    {
        try {
            return $profile->forceDelete();
        } catch (\Throwable $e) {
            return $profile->delete();
        }
    }
}
