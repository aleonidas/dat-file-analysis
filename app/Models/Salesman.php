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

    public static function averageSalaryOfSellers(array $file_processed)
    {
        $total_salary = 0;
        $quantity_salesman = self::getQuantity($file_processed);

        if ($quantity_salesman <= 0) {
            return 0;
        }

        foreach ($file_processed as $proc) {
            if (isset($proc['salesman'])) {
                $total_salary += floatval($proc['salesman']['salary']);
            }
        }

        return number_format(($total_salary / $quantity_salesman), 2, '.', '');
    }

}