<?php

namespace Modules\Setting\Models;

use App\BaseModel;

class Param extends BaseModel
{
    const UNIT_TYPE_UNIT = 1;
    const UNIT_TYPE_MASS = 2;
    const UNIT_TYPE_VOLUME = 3;

    public static function unitTypes()
    {
        return collect([
            (object) [ 'value' => self::UNIT_TYPE_UNIT, 'text' => 'UNIDAD' ],
            (object) [ 'value' => self::UNIT_TYPE_MASS, 'text' => 'MASA' ],
            (object) [ 'value' => self::UNIT_TYPE_VOLUME, 'text' => 'VOLUMEN' ],
        ]);
    }

}
