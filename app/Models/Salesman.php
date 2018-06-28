<?php

namespace App\Models;

class Salesman
{

    public static function getQuantity(array $file_processed)
    {
        $process = self::process($file_processed);
        return $process['quantity'];
    }

    public static function averageSalaryOfSellers(array $file_processed)
    {
        $process = self::process($file_processed);

        if ($process['quantity'] <= 0) {
            return 0;
        }

        return number_format(($process['total_salary'] / $process['quantity']), 2, '.', '');
    }

    protected static function process(array $file_processed)
    {
        $quantity = 0;
        $total_salary = 0;

        foreach ($file_processed as $proc) {
            if (isset($proc['salesman'])) {
                $quantity++;
                $total_salary += floatval($proc['salesman']['salary']);
            }
        }

        return [
            'quantity'     => $quantity,
            'total_salary' => $total_salary
        ];
    }

}