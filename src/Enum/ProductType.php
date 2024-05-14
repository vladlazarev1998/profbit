<?php

namespace App\Enum;

use App\Trait\EnumToArray;

enum ProductType: string
{
    use EnumToArray;

    case TYPE1 = 'type-1';

    case TYPE2 = 'type-2';

    case TYPE3 = 'type-3';
}