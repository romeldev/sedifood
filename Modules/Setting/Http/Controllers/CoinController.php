<?php

namespace Modules\Setting\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Setting\Models\Coin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use Modules\Setting\Http\Resources\CoinResource;

class CoinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Coin::orderBy('id_moneda', 'desc')->get();
        return response()->json( CoinResource::collection($data) );
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
            'name' => "required|unique:monedas,nombre,NULL,id_moneda",
            'abrev' => "required|unique:monedas,abreviado,NULL,id_moneda",
        ]);

        if( $validator->fails() ){
            return response()->json($validator->messages(), 422);
        }

        DB::beginTransaction();
        try {
            $nexId = Coin::orderBy('id_moneda', 'desc')->first()->id+1;
            $coin = new Coin;
            $coin->id = $nexId;
            $coin->name = $request->name;
            $coin->abrev = $request->abrev;
            $coin->save();
            DB::commit();
            return response()->json( new CoinResource(Coin::find($nexId)) );
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 501);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Coin  $coin
     * @return \Illuminate\Http\Response
     */
    public function show(Coin $coin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Coin  $coin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coin $coin)
    {
        $validator = Validator::make($request->all(), [
            'name' => "required|unique:monedas,nombre,$coin->id,id_moneda",
            'abrev' => "required|unique:monedas,abreviado,$coin->id,id_moneda",
        ]);

        if( $validator->fails() ){
            return response()->json($validator->messages(), 422);
        }

        DB::beginTransaction();
        try {
            $coin->name = $request->name;
            $coin->abrev = $request->abrev;
            $coin->save();
            DB::commit();
            return response()->json( new CoinResource($coin) );
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 501);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Coin  $coin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coin $coin)
    {
        DB::beginTransaction();
        try {
            $success = $coin->delete();
            DB::commit();
            return response()->json( $success );
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 501);
        }
    }
}
