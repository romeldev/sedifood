<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Catering\Models\Preparation;
use Modules\Setting\Models\FoodType;
use Modules\Setting\Models\Regime;
use Modules\Setting\Models\PreparationType;
use Modules\Setting\Models\NutrientColumn;
use Modules\Setting\Models\Param;
use Modules\Setting\Models\SupplyType;
use Modules\Setting\Models\Supply;
use Modules\Setting\Models\Unit;
use Modules\Setting\Models\Warehouse;
use Modules\Setting\Models\Professional;

class CommonController extends Controller
{
    public function index(Request $request)
    {
        switch($request->service){

            case 'get-meta-crud-supplies': return $this->getMetaCrudSupplies();

            case 'get-meta-crud-preparations': return $this->getMetaCrudPreparations();

            case 'get-meta-crud-programmings': return $this->getMetaCrudProgrammings();

            default: return null;
        }
    }

    private function getMetaCrudSupplies()
    {
        $data['unit_types'] = Param::unitTypes();
        $data['supply_types'] = SupplyType::all();
        $data['nutrient_columns'] = NutrientColumn::list();
        return response()->json($data);
    }

    private function getMetaCrudPreparations()
    {
        $data['preparation_types'] = PreparationType::all();
        $data['supplies'] = Supply::where('estado', 1)->get();
        $data['units'] = Unit::all();
        $data['warehouses'] = Warehouse::where('estado', 1)->get()->map(function($item){
            return [ 'id' => $item->id, 'name' => $item->name ];
        });

        return response()->json($data);
    }

    private function getMetaCrudProgrammings()
    {
        $data['professionals'] = Professional::select('id', 'fullname')->get();
        $data['regimes'] = Regime::select('id', 'descrip')->get();
        $data['food_types'] = FoodType::select('id', 'descrip')->get();
        
        $data['preparations'] = Preparation::all()->map(function($item) {
            return [ 'id' => $item->id, 'descrip' => $item->descrip ];
        });

        $data['warehouses'] = Warehouse::where('estado', 1)->get()->map(function($item){
            return [ 'id' => $item->id, 'name' => $item->name ];
        });

        return response()->json($data);
    }
}
