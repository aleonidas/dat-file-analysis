<?php

namespace App\Models;

class Salesman
{

    public static function getQuantity(array $file_processed)
    {
        $quantity = 0;
        foreach ($file_processed as $proc) {
            if (isset($proc['salesman'])) {
                $quantity++;
            }
        }

        return $quantity;
    }

}