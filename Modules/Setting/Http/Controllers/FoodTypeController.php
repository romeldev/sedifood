<?php

namespace Modules\Setting\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Setting\Models\FoodType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use Modules\Setting\Http\Resources\FoodTypeResource;

class FoodTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = FoodType::orderBy('id', 'desc')->get();
        return response()->json( FoodTypeResource::collection($data) );
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
            'descrip' => "required|unique:food_types,descrip,NULL,id,deleted_at,NULL",
        ]);

        if( $validator->fails() ){
            return response()->json($validator->messages(), 422);
        }

        DB::beginTransaction();
        try {
            $foodType = new FoodType;
            $foodType->descrip = $request->descrip;
            $foodType->save();
            DB::commit();
            return response()->json( new FoodTypeResource($foodType) );
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 501);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FoodType  $foodType
     * @return \Illuminate\Http\Response
     */
    public function show(FoodType $foodType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FoodType  $foodType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FoodType $foodType)
    {
        $validator = Validator::make($request->all(), [
            'descrip' => "required|unique:food_types,descrip,$foodType->id,id,deleted_at,NULL",
        ]);

        if( $validator->fails() ){
            return response()->json($validator->messages(), 422);
        }

        DB::beginTransaction();
        try {
            $foodType->descrip = $request->descrip;
            $foodType->save();
            DB::commit();
            return response()->json( new FoodTypeResource($foodType) );
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 501);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FoodType  $foodType
     * @return \Illuminate\Http\Response
     */
    public function destroy(FoodType $foodType)
    {
        DB::beginTransaction();
        try {
            $success = $foodType->delete();
            DB::commit();
            return response()->json( $success );
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 501);
        }
    }
}
