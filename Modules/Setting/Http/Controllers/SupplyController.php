<?php

namespace Modules\Setting\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Setting\Models\Supply;
use Modules\Setting\Models\Param;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use Modules\Setting\Http\Resources\SupplyResource;
use Modules\Setting\Http\Resources\SupplyNutrientResource;

class SupplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $data = Supply::where('estado', 1)->orderBy('id_insumo', 'desc')->get();
        $data = Supply::search($request->search)
        ->where('estado', 1)
        ->orderBy('id_insumo', 'desc')->with('supplyType')
        ->paginate(10);
        return SupplyResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $unitTypes = Param::unitTypes()->pluck('value')->toArray();
        $rules = [
            'name' => "required|unique:insumo,nombre,NULL,id_insumo,estado,1",
            'unit_type' => "required|in:".implode(',', $unitTypes),
            'supply_type_id' => "required|exists:food_groups,id",
            'grams' => "required",
            'net_weight' => "required",
        ];

        $validator = Validator::make($request->all(), $rules);

        if( $validator->fails() ){
            return response()->json($validator->messages(), 422);
        }

        DB::beginTransaction();
        try {
            $supply = new Supply;
            $supply->name = $request->name;
            $supply->unit_type = $request->unit_type;
            $supply->id_unidades = $request->unit_type;
            $supply->supply_type_id = $request->supply_type_id;
            $supply->estado = 1;
            $supply->es_insumo = 1;
            $supply->save();
            $supply->saveNutrient($request->nutrients);
            // return response()->json( new SupplyResource($supply) );
            DB::commit();
            return response()->json( new SupplyResource($supply) );
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 501);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Supply  $supply
     * @return \Illuminate\Http\Response
     */
    public function show(Supply $supply)
    {
        return response()->json( new SupplyNutrientResource($supply) );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Supply  $supply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supply $supply)
    {
        $unitTypes = Param::unitTypes()->pluck('value')->toArray();
        $rules = [
            'name' => "required|unique:insumo,nombre,$supply->id,id_insumo,estado,1",
            'unit_type' => "required|in:".implode(',', $unitTypes),
            'supply_type_id' => "required|exists:food_groups,id",
            'grams' => "required",
            'net_weight' => "required",
        ];

        $validator = Validator::make($request->all(), $rules);

        if( $validator->fails() ){
            return response()->json($validator->messages(), 422);
        }

        DB::beginTransaction();
        try {
            $supply->name = $request->name;
            $supply->unit_type = $request->unit_type;
            $supply->id_unidades = $request->unit_type;
            $supply->supply_type_id = $request->supply_type_id;
            $supply->estado = 1;
            $supply->es_insumo = 1;
            $supply->save();
            $supply->saveNutrient($request->nutrients);
            // return response()->json( new SupplyResource($supply) );
            DB::commit();
            return response()->json( new SupplyResource($supply) );
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 501);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Supply  $supply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supply $supply)
    {
        DB::beginTransaction();
        try {
            $success = $supply->update(['estado' => 0]);
            // return response()->json( success );
            DB::commit();
            return response()->json( $success );
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 501);
        }
    }
}
