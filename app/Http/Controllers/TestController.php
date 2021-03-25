<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Modules\Setting\Models\NutrientColumn;
use Modules\Setting\Models\Unit;
use Modules\Catering\Models\Preparation;
use PHPJasper\PHPJasper;
use Storage;

class TestController extends Controller
{
    public function index(Request $request)
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
