<?php

namespace App\Data;

class Sales implements InterfaceData
{

    public static function get(string $row)
    {
        $items = Item::get($row);
        $row = explode(',', $row);

        return [
            'sales' => [
                'id'            => $row[0],
                'sale_id'       => $row[1],
                'items'         => $items,
                'salesman_id'   => $row[5],
                'total'         => $items['total']
            ]
        ];
    }

}