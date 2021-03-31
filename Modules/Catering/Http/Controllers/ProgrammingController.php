<?php

namespace Modules\Catering\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Catering\Models\Programming;
use Illuminate\Http\Request;
use Modules\Catering\Http\Resources\ProgrammingResource;
use Illuminate\Support\Facades\Validator;
use DB;

class ProgrammingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'warehouse_id' => "required|integer|gt:0",
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from',
        ]);

        if( $validator->fails() ){
            return response()->json($validator->messages(), 422);
        }

        $data = Programming::orderBy('date', 'desc')
        ->where('company_id', $request->warehouse_id)
        ->whereDate('date', '>=', $request->date_from)
        ->whereDate('date', '<=', $request->date_to)
        ->with(['professional', 'regime', 'foodType', 'programmingDetails'=>function($query){
            return $query->with('preparation');
        }])
        ->get();

        return response()->json(ProgrammingResource::collection($data));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'warehouse_id' => "required|integer|gt:0",
            'date' => "required|date",
            'professional_id' => "required|exists:professionals,id,deleted_at,NULL",
            'regime_id' => "required|exists:regimes,id,deleted_at,NULL",
            'food_type_id' => "required|exists:food_types,id,deleted_at,NULL",
            'programming_details' => "required|array|min:1",
            'programming_details.*.portions' => "required|integer|gt:0"
        ]);

        $validator->after( function($validator) {
            $date = request()->date;
            $warehouseId = request()->warehouse_id;
            $regimeId = request()->regime_id;
            $foodTypeId = request()->food_type_id;

            if( $warehouseId && $regimeId && $foodTypeId) {
                $prog = Programming::where('company_id', $warehouseId)
                ->where('regime_id', $regimeId)
                ->where('food_type_id', $foodTypeId)
                ->whereDate('date', $date)
                ->first();

                if($prog) {
                    $validator->errors()->add('prog_exists', 'Ya existe una programacion con la misma configuracion (sucursal, fecha, regimen, tipo comida)');
                }
            }
        });

        if( $validator->fails() ){
            return response()->json($validator->messages(), 422);
        }

        DB::beginTransaction();
        try {
            $programming = new Programming;
            $programming->warehouse_id = $request->warehouse_id;
            $programming->date = $request->date;
            $programming->professional_id = $request->professional_id;
            $programming->regime_id = $request->regime_id;
            $programming->food_type_id = $request->food_type_id;
            $programming->save();
            $programming->saveDetails($request->programming_details);
            // return response()->json( new ProgrammingResource($programming) );
            DB::commit();
            return response()->json( new ProgrammingResource($programming) );
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 501);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Programming  $programming
     * @return \Illuminate\Http\Response
     */
    public function show(Programming $programming)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Programming  $programming
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Programming $programming)
    {
        $validator = Validator::make($request->all(), [
            'warehouse_id' => "required|integer|gt:0",
            'date' => "required|date",
            'professional_id' => "required|exists:professionals,id,deleted_at,NULL",
            'regime_id' => "required|exists:regimes,id,deleted_at,NULL",
            'food_type_id' => "required|exists:food_types,id,deleted_at,NULL",
            'programming_details' => "required|array|min:1",
            'programming_details.*.portions' => "required|integer|gt:0"
        ]);


        $validator->after( function($validator) {
            $date = request()->date;
            $warehouseId = request()->warehouse_id;
            $regimeId = request()->regime_id;
            $foodTypeId = request()->food_type_id;

            if( $warehouseId && $regimeId && $foodTypeId) {
                $prog = Programming::where('company_id', $warehouseId)
                ->where('regime_id', $regimeId)
                ->where('food_type_id', $foodTypeId)
                ->whereDate('date', $date)
                ->where('id', '<>', request()->id)
                ->first();

                if($prog) {
                    $validator->errors()->add('prog_exists', 'Ya existe una programacion con la misma configuracion (sucursal, fecha, regimen, tipo comida)');
                }
            }
        });

        if( $validator->fails() ){
            return response()->json($validator->messages(), 422);
        }

        DB::beginTransaction();
        try {
            $programming->warehouse_id = $request->warehouse_id;
            $programming->date = $request->date;
            $programming->professional_id = $request->professional_id;
            $programming->regime_id = $request->regime_id;
            $programming->food_type_id = $request->food_type_id;
            $programming->save();
            $programming->programmingDetails()->forceDelete();
            $programming->saveDetails($request->programming_details);
            // return response()->json( new ProgrammingResource($programming) );
            DB::commit();
            return response()->json( new ProgrammingResource($programming) );
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 501);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Programming  $programming
     * @return \Illuminate\Http\Response
     */
    public function destroy(Programming $programming)
    {
        DB::beginTransaction();
        try {
            $programming->programmingDetails()->forceDelete();
            $success = $programming->forceDelete();
            DB::commit();
            return response()->json( $success );
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 501);
        }
    }
}
