<?php

namespace Modules\Catering\Models;

use App\BaseModel;
use Storage;
use PHPJasper\PHPJasper;

class Report extends BaseModel
{

    const NC_ALL = "CONTENIDO NUTRICIONAL";
    const NC_MACRO = "CONTENIDO NUTRICIONAL - MACRO NUTRIENTES";
    const NC_MINERAL = "CONTENIDO NUTRICIONAL - MINERALES";
    const NC_VITAMIN = "CONTENIDO NUTRICIONAL - VITAMINAS";
    const NC_CONSOLIDED = "CONTENIDO VALORES CONSOLIDADOS";

    const NC_STATISTIC = "ESTADISTICA NUTRICIONAL";
    const NC_PREPARATION = "CONTENIDO NUTRICIONAL - MINERALES";
    
    const ORDER_DETAILED = "DETALLADO";
    const ORDER_CONSOLIDED = "CONSOLIDADO";
    const ORDER_CONSOLIDED_STOCK = "CONSOLIDADO - STOCK";

    public static function supplyOrderReports()
    {
        return collect([
            [ 'reportname' => 'order_detailed', 'label' => 'DETALLADO' ],
            [ 'reportname' => 'order_consolided', 'label' => 'CONSOLIDADO' ],
            [ 'reportname' => 'order_consolided_stock', 'label' => 'CONSOLIDADO - STOCK' ],
        ]);
    }

    public static function nutritionalContentReports()
    {
        return collect([
            [ 'reportname' => 'nc_all', 'label' => 'CONTENIDO NUTRICIONAL' ],
            [ 'reportname' => 'nc_macro', 'label' => 'CONTENIDO NUTRICIONAL - MACRO NUTRIENTES' ],
            [ 'reportname' => 'nc_minerals', 'label' => 'CONTENIDO NUTRICIONAL - MINERALES' ],
            [ 'reportname' => 'nc_vitamins', 'label' => 'CONTENIDO NUTRICIONAL - VITAMINAS' ],
            [ 'reportname' => 'nc_consolidated', 'label' => 'CONTENIDO VALORES CONSOLIDADOS' ],
        ]);
    }


    public static function reportNameFile( $reportName )
    {
        switch( $reportName ){
            case Report::NC_ALL: return "nc_all";
            case Report::NC_MACRO: return "nc_macro";
            case Report::NC_MINERAL: return "nc_minerals";
            case Report::NC_VITAMIN: return "nc_vitamins";
            case Report::NC_CONSOLIDED: return "nc_consolidated";
            case Report::NC_STATISTIC: return "nc_adecuacy";
            case Report::ORDER_DETAILED: return "order_detailed";
            case Report::ORDER_CONSOLIDED: return "order_consolided";
            case Report::ORDER_CONSOLIDED_STOCK: return "order_consolided_stock";
            default: return;
        }
    }

    

    public static function generate($reportname, $params)
    {
        $input = Storage::path("ireport/reports/$reportname.jasper");

        if (!Storage::disk('local')->exists("/ireport/reports/$reportname.jasper")) {
            throw new \Exception("La plantilla de report $reportname.jasper no existe", 500);
        }

        $output = base_path("storage/app/ireport/results/$reportname");

        $driver = config('database.default');
        $db = config("database.connections.$driver");

        $options = [ 
            'format' => ['pdf'],
            'params' => $params,
            'db_connection' => [
                'driver' => $driver,
                'username' => $db['username'],
                'password' => $db['password'],
                'host' => $db['host'],
                'database' => $db['database'],
                'port' => $db['port']
            ]
        ];
        // dd($options);


        $jasper = new PHPJasper;

        // $output = $jasper->listParameters($input)->execute();
        // foreach($output as $parameter_description) print $parameter_description . '<pre>';
        // die();

        $jasper->process(
            $input,
            $output,
            $options
        )->execute();

        $filename = $output.'.pdf';
        return response()->file($filename)->deleteFileAfterSend(true);
    }
}
