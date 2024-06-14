<?php

namespace Modules\Category\App\Filters;

use EloquentFilter\ModelFilter;

class CategoryFilter extends ModelFilter
{

    public function search($search)
    {
        return $this->where(function ($q) use ($search) {
            return $q->whereTranslationLike('name', 'LIKE', "%$search%")
                ->orWhere('code', 'LIKE', "%$search%");
        });
    }
    public function code($code)
    {
        return $this->where(function ($q) use ($code) {
            return $q->where('code', $code);
        });
    }
}
