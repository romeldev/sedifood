<?php

namespace Modules\Catering\Models;

use App\BaseModel;

class Report extends BaseModel
{
    public static function supplyOrderReports()
    {
        return collect([
            [ 'name' => 'report_1', 'label' => 'Detallado' ],
            [ 'name' => 'report_2', 'label' => 'Consolidado' ],
            [ 'name' => 'report_3', 'label' => 'Consolidado - Stock' ],
        ]);
    }
}
