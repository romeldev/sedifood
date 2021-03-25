<?php

namespace Modules\Setting\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Setting\Models\Regime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use Modules\Setting\Http\Resources\RegimeResource;

class RegimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Regime::orderBy('id', 'desc')->get();
        return response()->json( RegimeResource::collection($data) );
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
            'descrip' => "required|unique:regimes,descrip,NULL,id,deleted_at,NULL",
        ]);

        if( $validator->fails() ){
            return response()->json($validator->messages(), 422);
        }

        DB::beginTransaction();
        try {
            $regime = new Regime;
            $regime->descrip = $request->descrip;
            $regime->company_id = 1;
            $regime->save();
            DB::commit();
            return response()->json( new RegimeResource($regime) );
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 501);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Regime  $regime
     * @return \Illuminate\Http\Response
     */
    public function show(Regime $regime)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Regime  $regime
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Regime $regime)
    {
        $validator = Validator::make($request->all(), [
            'descrip' => "required|unique:regimes,descrip,$regime->id,id,deleted_at,NULL",
        ]);

        if( $validator->fails() ){
            return response()->json($validator->messages(), 422);
        }

        DB::beginTransaction();
        try {
            $regime->descrip = $request->descrip;
            $regime->save();
            DB::commit();
            return response()->json( new RegimeResource($regime) );
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 501);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Regime  $regime
     * @return \Illuminate\Http\Response
     */
    public function destroy(Regime $regime)
    {
        DB::beginTransaction();
        try {
            $success = $regime->delete();
            DB::commit();
            return response()->json( $success );
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 501);
        }
    }
}
