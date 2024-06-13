<?php

namespace Modules\Admin\App\Filters;

use EloquentFilter\ModelFilter;

class AdminFilter extends ModelFilter
{

    public function search($search)
    {
        return $this->where(function ($q) use ($search) {
            return $q->where('name', 'LIKE', "%$search%")
                ->orWhere('phone', 'LIKE', "%$search%")
                ->orWhere('email', 'LIKE', "%$search%");
        });
    }
    public function roleId($roleId)
    {
        return $this->where(function ($q) use ($roleId) {
            return $q->where('role_id', $roleId);
        });
    }
    public function status($status)
    {
        return $this->where(function ($q) use ($status) {
            return $q->where('status', $status);
        });
    }
}
