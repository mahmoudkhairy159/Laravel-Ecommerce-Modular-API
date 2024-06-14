<?php

namespace Modules\Category\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Area\Database\factories\CountryTranslationFactory;

class CategoryTranslation extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description'];
    public $timestamps = false;
}
