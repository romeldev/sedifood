<?php

namespace Modules\Setting\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Setting\Models\PreparationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use Modules\Setting\Http\Resources\PreparationTypeResource;

class PreparationTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = PreparationType::orderBy('id', 'desc')->get();
        return response()->json( PreparationTypeResource::collection($data) );
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
            'descrip' => "required|unique:preparation_types,descrip,NULL,id,deleted_at,NULL",
        ]);

        if( $validator->fails() ){
            return response()->json($validator->messages(), 422);
        }

        DB::beginTransaction();
        try {
            $preparationType = new PreparationType;
            $preparationType->descrip = $request->descrip;
            $preparationType->save();
            DB::commit();
            return response()->json( new PreparationTypeResource($preparationType) );
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 501);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PreparationType  $preparationType
     * @return \Illuminate\Http\Response
     */
    public function show(PreparationType $preparationType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PreparationType  $preparationType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PreparationType $preparationType)
    {
        $validator = Validator::make($request->all(), [
            'descrip' => "required|unique:preparation_types,descrip,$preparationType->id,id,deleted_at,NULL",
        ]);

        if( $validator->fails() ){
            return response()->json($validator->messages(), 422);
        }

        DB::beginTransaction();
        try {
            $preparationType->descrip = $request->descrip;
            $preparationType->save();
            DB::commit();
            return response()->json( new PreparationTypeResource($preparationType) );
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 501);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PreparationType  $preparationType
     * @return \Illuminate\Http\Response
     */
    public function destroy(PreparationType $preparationType)
    {
        DB::beginTransaction();
        try {
            $success = $preparationType->delete();
            DB::commit();
            return response()->json( $success );
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 501);
        }
    }
}
