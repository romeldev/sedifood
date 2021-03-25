<?php

namespace Modules\Setting\Models;

use Illuminate\Database\Eloquent\Model;

class NutrientColumn extends Model
{
    public $table = 'nutrient_columns';

    protected $fillable = [];

    public static function list()
    {
        $data = NutrientColumn::whereNotIn('column', ['grams'])->get();
        return $data;
    }
}
