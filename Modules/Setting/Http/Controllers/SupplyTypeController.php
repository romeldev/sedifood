<?php

namespace Modules\Setting\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Setting\Models\SupplyType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use Modules\Setting\Http\Resources\SupplyTypeResource;

class SupplyTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = SupplyType::orderBy('id', 'desc')->get();
        return response()->json( SupplyTypeResource::collection($data) );
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
            'descrip' => "required|unique:food_groups,descrip,NULL,id,deleted_at,NULL",
            'abrev' => "required|unique:food_groups,abrev,NULL,id,deleted_at,NULL",
        ]);

        if( $validator->fails() ){
            return response()->json($validator->messages(), 422);
        }

        DB::beginTransaction();
        try {
            $supplyType = new SupplyType;
            $supplyType->descrip = $request->descrip;
            $supplyType->abrev = $request->abrev;
            $supplyType->save();
            DB::commit();
            return response()->json( new SupplyTypeResource($supplyType) );
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 501);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SupplyType  $supplyType
     * @return \Illuminate\Http\Response
     */
    public function show(SupplyType $supplyType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SupplyType  $supplyType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SupplyType $supplyType)
    {
        $validator = Validator::make($request->all(), [
            'descrip' => "required|unique:food_groups,descrip,$supplyType->id,id,deleted_at,NULL",
            'abrev' => "required|unique:food_groups,abrev,$supplyType->id,id,deleted_at,NULL",
        ]);

        if( $validator->fails() ){
            return response()->json($validator->messages(), 422);
        }

        DB::beginTransaction();
        try {
            $supplyType->descrip = $request->descrip;
            $supplyType->abrev = $request->abrev;
            $supplyType->save();
            DB::commit();
            return response()->json( new SupplyTypeResource($supplyType) );
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 501);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SupplyType  $supplyType
     * @return \Illuminate\Http\Response
     */
    public function destroy(SupplyType $supplyType)
    {
        DB::beginTransaction();
        try {
            $success = $supplyType->delete();
            DB::commit();
            return response()->json( $success );
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 501);
        }
    }
}
