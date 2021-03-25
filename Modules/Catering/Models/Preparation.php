<?php

namespace Modules\Catering\Models;

use App\BaseModel;
use Modules\Setting\Models\PreparationType;
use Modules\Setting\Models\Supply;
use Modules\Setting\Models\Unit;

class Preparation extends BaseModel
{
    public $table = 'preparations';

    protected $fillable = [ 
        'descrip',
        'preparation_type_id',
        'company_id', //warehouse_id
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

    public function preparationType()
    {
        return $this->belongsTo(PreparationType::class, 'preparation_type_id', 'id');
    }

    public function preparationDetails()
    {
        return $this->hasMany(PreparationDetail::class, 'preparation_id', 'id');
    }

    public function saveDetails($htmlTable)
    {
        $preparation = $this;
        $htmlTable  = collect($htmlTable);

        $dbSupplies = Supply::whereIn('id_insumo', $htmlTable->pluck('supply_id')->toArray())->get();
        $dbUnits = Unit::all();
        // dd($dbSupplies->toArray());

        $preparationDetails = [];
        foreach($dbSupplies as $supply) {
            $row = $htmlTable->firstWhere('supply_id', $supply->id);
            $unit = $dbUnits->firstWhere('id', $row['unit_id']);
            $amount = $row['amount'];

            $preparationDetail = new PreparationDetail();
            // $preparationDetail->preparation_id = $preparation->id;
            $preparationDetail->supply_id = $supply->id;
            $preparationDetail->unit_id = $unit->id;
            $preparationDetail->unit_type = $unit->type;
            $preparationDetail->amount = $amount;
            $preparationDetail->amount_m = $amount * $unit->factor;
            $preparationDetail->amount_s = $amount * ($unit->factor/$unit->unitS()->factor);
            // $preparationDetail->save();
            $preparationDetails[] = $preparationDetail;
        };

        return $preparation->preparationDetails()->saveMany($preparationDetails);
    }
}
