<?php

namespace Modules\User\App\Repositories;

use Modules\User\App\Models\UserProfile;
use Prettus\Repository\Eloquent\BaseRepository;

class UserProfileRepository extends BaseRepository
{
    public function model()
    {
        return UserProfile::class;
    }
}
