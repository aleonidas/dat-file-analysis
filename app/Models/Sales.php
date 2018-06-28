<?php

namespace App\Models;

class Sales
{

    public static function bestSelling(array $file_processed)
    {
        $sale_id = null;
        $sale_total = 0;

        foreach ($file_processed as $proc) {
            if (isset($proc['sales'])) {
                if ($proc['sales']['total'] > $sale_total) {
                    $sale_total = $proc['sales']['total'];
                    $sale_id   = $proc['sales']['sale_id'];
                }
            }
        }

        return $sale_id;
    }

    public static function worstSeller(array $file_processed)
    {
        $salesman_id = null;
        $sale_total  = null;

        foreach ($file_processed as $proc) {
            if (isset($proc['sales'])) {
                $sale_total = (is_null($sale_total) ? $proc['sales']['total'] : $sale_total);

                if ($proc['sales']['total'] < $sale_total) {
                    $sale_total  = $proc['sales']['total'];
                    $salesman_id = $proc['sales']['salesman_id'];
                }
            }
        }

        return $salesman_id;
    }

}