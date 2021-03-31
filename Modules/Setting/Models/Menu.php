<?php

namespace Modules\Setting\Models;

use App\BaseModel;

class Menu extends BaseModel
{
    public $table = 'food_Types';

    protected $fillable = [ 

    ];

    public static function data() 
    {
        return 
        [
            [ 'name' => 'Mantenimiento', 'icon' => 'mdi-cogs', 'path' => '/setting',
                'children' => [
                    [ 'name' => 'Regimenes', 'icon' => 'mdi-checkbox-blank-circle-outline', 'path' => '/setting/regimes' ],
                    [ 'name' => 'T.Insumos', 'icon' => 'mdi-checkbox-blank-circle-outline', 'path' => '/setting/supply-types' ],
                    [ 'name' => 'T.Preparaciones', 'icon' => 'mdi-checkbox-blank-circle-outline', 'path' => '/setting/preparation-types' ],
                    [ 'name' => 'T.Comidas', 'icon' => 'mdi-checkbox-blank-circle-outline', 'path' => '/setting/food-types' ],
                    [ 'name' => 'Monedas', 'icon' => 'mdi-checkbox-blank-circle-outline', 'path' => '/setting/coins' ],
                    [ 'name' => 'Profesionales', 'icon' => 'mdi-checkbox-blank-circle-outline', 'path' => '/setting/professionals' ],
                ]
            ],

            [ 'name' => 'Alimentos', 'icon' => 'mdi-food', 'path' => '/catering',
                'children' => [
                    [ 'name' => 'Insumos y Nutrientes', 'icon' => 'mdi-checkbox-blank-circle-outline', 'path' => '/setting/supplies' ],
                ]
            ],

            [ 'name' => 'Prog. Menu', 'icon' => 'mdi-folder-open', 'path' => '/catering',
                'children' => [
                    [ 'name' => 'Preparaciones', 'icon' => 'mdi-checkbox-blank-circle-outline', 'path' => '/catering/preparations' ],
                    [ 'name' => 'Programaciones', 'icon' => 'mdi-checkbox-blank-circle-outline', 'path' => '/catering/programmings' ],
                ]
            ],

            [ 'name' => 'Orden Pedido', 'icon' => 'mdi-file-document-multiple-outline', 'path' => '/report',
                'children' => [
                    [ 'name' => 'Reporte', 'icon' => 'mdi-checkbox-blank-circle-outline', 'path' => '/report/supply-order' ],
                ]
            ],

            [ 'name' => 'Estadisticas y AN', 'icon' => 'mdi-poll', 'path' => '/stats',
                'children' => [
                    [ 'name' => 'Contenido Nutricional', 'icon' => 'mdi-checkbox-blank-circle-outline', 'path' => '/stats/nutritional-content' ],
                    [ 'name' => 'Preparaciones', 'icon' => 'mdi-checkbox-blank-circle-outline', 'path' => '/stats/preparation-content' ],
                ]
            ],
        ];
    }
}
