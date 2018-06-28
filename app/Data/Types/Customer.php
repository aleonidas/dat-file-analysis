<?php

namespace App\Data\Types;

use App\Data\InterfaceTypes;

class Customer implements InterfaceTypes
{

    public static function get(string $row)
    {
        $row = explode(',', $row);
        return [
            'customer' => [
                'id'            => $row[0],
                'cnpj'          => $row[1],
                'name'          => $row[2],
                'business_area' => $row[3]
            ]
        ];
    }

}