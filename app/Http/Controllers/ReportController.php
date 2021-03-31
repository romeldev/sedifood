<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPJasper\PHPJasper;
use Storage;

class ReportController extends Controller
{
    public function index(Request $request, $type)
    {
        $reportName = 'report1';

        $input = Storage::path("/ireport/templates/$reportName.jasper");

        $output = base_path("/storage/app/ireport/results/$reportName");

        $options = [ 
            'format' => ['pdf'] 
        ];

        $jasper = new PHPJasper;

        $jasper->process(
            $input,
            $output,
            $options
        )->execute();


        $filename = $output.'.pdf';

        return response()->file($filename)->deleteFileAfterSend(true);
    }
}
