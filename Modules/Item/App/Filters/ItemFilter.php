<?php

namespace Modules\Item\App\Filters;

use EloquentFilter\ModelFilter;

class ItemFilter extends ModelFilter
{

    public function search($search)
    {
        return $this->where(function ($q) use ($search) {
            return $q->whereTranslationLike('name', 'LIKE', "%$search%")
                ->whereTranslationLike('short_description', 'LIKE', "%$search%")
                ->whereTranslationLike('description', 'LIKE', "%$search%")
                ->orWhere('code', 'LIKE', "%$search%");
        });
    }
    public function code($code)
    {
        return $this->where(function ($q) use ($code) {
            return $q->where('code', $code);
        });
    }
    public function categoryId($categoryId)
    {
        return $this->where(function ($q) use ($categoryId) {
            return $q->where('category_id', $categoryId);
        });
    }
    public function brandId($brandId)
    {
        return $this->where(function ($q) use ($brandId) {
            return $q->where('brand_id', $brandId);
        });
    }
    public function fromPrice($fromPrice)
    {
        if (request()->toPrice === null) {
            return $this->where(function ($q) use ($fromPrice) {
                return $q->where('price', $fromPrice);
            });
        }
        return $this->where(function ($q) use ($fromPrice) {
            return $q->where('price', '>=', $fromPrice);
        });
    }
    public function toPrice($toPrice)
    {
        if (request()->fromPrice === null) {
            return $this->where(function ($q) use ($toPrice) {
                return $q->where('price', $toPrice);
            });
        }
        return $this->where(function ($q) use ($toPrice) {
            return $q->where('price', '<=', $toPrice);
        });
    }
}
