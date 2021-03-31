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
        $reports = Report::supplyOrderReports()->pluck('name')->toArray();

        $validator = Validator::make($request->all(), [
            'warehouse_id' => 'required|integer|gt:0',
            'regime_id' => 'required|integer|gt:0',
            'food_type_id' => 'required|integer|gt:0',
            'report' => 'required|in:'.implode(',', $reports),
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from',
        ]);

        if( $validator->fails() ){
            return response()->json($validator->messages(), 422);
        }
        
        return response()->json($request->all());
    }

    public function generateReportSupplyOrder(Request $request) 
    {
        dd($request->all());
    }

}
