<?php

namespace Modules\Setting\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Setting\Models\Professional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use Modules\Setting\Http\Resources\ProfessionalResource;

class ProfessionalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Professional::orderBy('id', 'desc')->get();
        return response()->json( ProfessionalResource::collection($data) );
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
            'fullname' => "required",
            'profession' => "required",
            'code' => "required|unique:professionals,code,NULL,id,deleted_at,NULL",
        ]);

        if( $validator->fails() ){
            return response()->json($validator->messages(), 422);
        }

        DB::beginTransaction();
        try {
            $professional = new Professional;
            $professional->fullname = $request->fullname;
            $professional->profession = $request->profession;
            $professional->code = $request->code;
            $professional->save();
            DB::commit();
            return response()->json( new ProfessionalResource($professional) );
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 501);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Professional  $professional
     * @return \Illuminate\Http\Response
     */
    public function show(Professional $professional)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Professional  $professional
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Professional $professional)
    {
        $validator = Validator::make($request->all(), [
            'fullname' => "required",
            'profession' => "required",
            'code' => "required|unique:professionals,code,$professional->id,id,deleted_at,NULL",
        ]);

        if( $validator->fails() ){
            return response()->json($validator->messages(), 422);
        }

        DB::beginTransaction();
        try {
            $professional->fullname = $request->fullname;
            $professional->profession = $request->profession;
            $professional->code = $request->code;
            $professional->save();
            DB::commit();
            return response()->json( new ProfessionalResource($professional) );
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 501);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Professional  $professional
     * @return \Illuminate\Http\Response
     */
    public function destroy(Professional $professional)
    {
        DB::beginTransaction();
        try {
            $success = $professional->delete();
            DB::commit();
            return response()->json( $success );
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 501);
        }
    }
}
