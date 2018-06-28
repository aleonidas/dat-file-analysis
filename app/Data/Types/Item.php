<?php

namespace App\Data\Types;

use App\Data\InterfaceTypes;

class Item implements InterfaceTypes
{

    public static function get(string $row)
    {
        $items = explode('[', $row);
        $items = explode(']', $items[1]);
        $items = explode(',', $items[0]);
        $items = str_replace(' ', '', $items);
        $total = 0;

        foreach ($items as $key => $item) {
            $it = explode('-', $item);
            $items_sale[$key]['id']        = $it[0];
            $items_sale[$key]['quantity']  = $it[1];
            $items_sale[$key]['price']     = $it[2];
            $items_sale[$key]['subtotal']  = ($it[2] * $it[1]);
            $total += ($it[2] * $it[1]);
        }

        $items_sale['total'] = $total;

        return $items_sale;
    }

}