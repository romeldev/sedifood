<?php

namespace Modules\Catering\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Catering\Models\Preparation;
use Illuminate\Http\Request;
use Modules\Catering\Http\Resources\PreparationResource;
use Illuminate\Support\Facades\Validator;
use DB;

class PreparationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Preparation::all();
        return response()->json( PreparationResource::collection($data) );
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
            'descrip' => "required|unique:preparations,descrip,NULL,id,deleted_at,NULL",
            'preparation_type_id' => "required|exists:preparation_types,id,deleted_at,NULL",
            'preparation_details' => 'required|array|min:1',
            'preparation_details.*.supply_id' => 'required|exists:insumo,id_insumo,estado,1',
            'preparation_details.*.amount' => 'required|numeric|gt:0',
            'preparation_details.*.unit_id' => 'required|exists:units,id,deleted_at,NULL',
        ]);

        if( $validator->fails() ){
            return response()->json($validator->messages(), 422);
        }

        DB::beginTransaction();
        try {
            $preparation = new Preparation;
            $preparation->descrip = $request->descrip;
            $preparation->preparation_type_id = $request->preparation_type_id;
            $preparation->warehouse_id = $request->warehouse_id;
            $preparation->save();
            $preparation->saveDetails($request->preparation_details);
            // return response()->json( new PreparationResource($preparation) );
            DB::commit();
            return response()->json( new PreparationResource($preparation) );
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 501);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Preparation  $preparation
     * @return \Illuminate\Http\Response
     */
    public function show(Preparation $preparation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Preparation  $preparation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Preparation $preparation)
    {
        $validator = Validator::make($request->all(), [
            'warehouse_id' => "required|integer|gt:0",
            'descrip' => "required|unique:preparations,descrip,$preparation->id,id,deleted_at,NULL",
            'preparation_type_id' => "required|exists:preparation_types,id,deleted_at,NULL",
            'preparation_details' => 'required|array|min:1',
            'preparation_details.*.supply_id' => 'required|exists:insumo,id_insumo,estado,1',
            'preparation_details.*.amount' => 'required|numeric|gt:0',
            'preparation_details.*.unit_id' => 'required|exists:units,id,deleted_at,NULL',
        ]);

        if( $validator->fails() ){
            return response()->json($validator->messages(), 422);
        }

        DB::beginTransaction();
        try {
            $preparation->descrip = $request->descrip;
            $preparation->preparation_type_id = $request->preparation_type_id;
            $preparation->warehouse_id = $request->warehouse_id;
            $preparation->save();
            $preparation->preparationDetails()->forceDelete();
            $preparation->saveDetails($request->preparation_details);
            // return response()->json( new PreparationResource($preparation) );
            DB::commit();
            return response()->json( new PreparationResource($preparation) );
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 501);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Preparation  $preparation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Preparation $preparation)
    {
        DB::beginTransaction();
        try {
            $preparation->preparationDetails()->delete();
            $success = $preparation->delete();
            DB::commit();
            return response()->json( $success );
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 501);
        }
    }
}
