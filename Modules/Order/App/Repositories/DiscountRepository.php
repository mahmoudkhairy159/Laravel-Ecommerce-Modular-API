<?php

namespace Modules\Order\App\Repositories;

use Modules\Order\App\Models\Discount;
use Prettus\Repository\Eloquent\BaseRepository;

class DiscountRepository extends BaseRepository
{
    public function model()
    {
        return Discount::class;
    }

}
