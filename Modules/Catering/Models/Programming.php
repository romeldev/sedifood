<?php

namespace Modules\Catering\Models;

use App\BaseModel;
use Modules\Setting\Models\Professional;
use Modules\Setting\Models\FoodType;
use Modules\Setting\Models\Regime;

class Programming extends BaseModel
{
    public $table = 'programmings';

    protected $fillable = [ 
        'date',
        'company_id',
        'professional_id',
        'regime_id',
        'food_type_id',
    ];

    protected $casts = [
        'date' => 'date'
    ];

    protected $appends = [ 'warehouse_id' ];

    public function getWarehouseIdAttribute() 
    {
        return $this->attributes['company_id'];
    }

    public function setWarehouseIdAttribute($value) 
    {
        return $this->attributes['company_id'] = $value;
    }

    public function professional()
    {
        return $this->belongsTo(Professional::class)->withDefault();
    }

    public function foodType()
    {
        return $this->belongsTo(FoodType::class)->withDefault();
    }

    public function regime()
    {
        return $this->belongsTo(Regime::class)->withDefault();
    }

    public function programmingDetails()
    {
        return $this->hasMany(ProgrammingDetail::class);
    }

    public function saveDetails($htmlTable)
    {
        $programming = $this;
        $htmlTable  = collect($htmlTable);

        $dbPreparations = Preparation::whereIn('id', $htmlTable->pluck('preparation_id')->toArray())->get();

        $programmingDetails = [];
        foreach($dbPreparations as $preparation) {
            $row = $htmlTable->firstWhere('preparation_id', $preparation->id);
            $programmingDetail = new ProgrammingDetail();
            // $programmingDetail->programming_id = $programming->id;
            $programmingDetail->preparation_id = $preparation->id;
            $programmingDetail->portions = $row['portions'];
            // $programmingDetail->save();
            $programmingDetails[] = $programmingDetail;
        };

        return $programming->programmingDetails()->saveMany($programmingDetails);
    }
}
