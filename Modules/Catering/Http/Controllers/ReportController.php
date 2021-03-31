<?php

namespace Modules\Catering\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Catering\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;

class ReportController extends Controller
{
    public function reportSupplyOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reportname' => 'required',
            'warehouse_id' => 'required|integer|gt:0',
            'regime_id' => 'required|integer|gt:0',
            'food_type_id' => 'required|integer|gt:0',
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from',
        ]);

        if( $validator->fails() ){
            return response()->json( $validator->messages(), 422 );
        }

        $data['reportname'] = $request->reportname;

        $data['params'] = [
            'DATE_FROM' => $request->date_from,
            'DATE_TO' => $request->date_to,
            'COMPANY_ID' => $request->warehouse_id,
            'REGIME_ID' => $request->regime_id,
            'FOOD_TYPE_ID' => $request->food_type_id
        ];
        return response()->json($data);
    }

    public function reportNutritionalContent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reportname' => 'required',
            'warehouse_id' => 'required|integer|gt:0',
            'regime_id' => 'required|integer|gt:0',
            'food_type_id' => 'required|integer|gt:0',
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from',
        ]);

        if( $validator->fails() ){
            return response()->json( $validator->messages(), 422 );
        }

        $data['reportname'] = $request->reportname;

        $data['params'] = [
            'DATE_FROM' => $request->date_from,
            'DATE_TO' => $request->date_to,
            'COMPANY_ID' => $request->warehouse_id,
            'REGIME_ID' => $request->regime_id,
            'FOOD_TYPE_ID' => $request->food_type_id
        ];
        return response()->json($data);
    }

    public function reportPreparationContent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reportname' => 'required',
            'warehouse_id' => 'required|integer|gt:0',
            'preparation_id' => 'required|integer|gt:0',
        ]);

        if( $validator->fails() ){
            return response()->json( $validator->messages(), 422 );
        }

        $data['reportname'] = $request->reportname;

        $data['params'] = [
            'COMPANY_ID' => $request->warehouse_id,
            'PREPARATION_ID' => $request->preparation_id
        ];

        return response()->json( $data );
    }

    public function generate(Request $request, $reportname)
    {
        return Report::generate($reportname, $request->all());
    }


}
