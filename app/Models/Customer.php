<?php

namespace App\Models;

class Customer
{

    public static function getQuantity(array $file_processed)
    {
        $quantity = 0;
        foreach ($file_processed as $proc) {
            if (isset($proc['customer'])) {
                $quantity++;
            }
        }

        return $quantity;
    }

}