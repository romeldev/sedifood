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

        $input = Storage::path("ireport/templates/$reportName.jasper");

        if (!Storage::disk('local')->exists("/ireport/templates/$reportName.jasper")) {
            dd("/ireport/templates/$reportName.jasper not found!");
        }

        $output = base_path("storage/app/ireport/results/$reportName");

        // dd([ 'input' => $input, 'output' => $output ]);

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
