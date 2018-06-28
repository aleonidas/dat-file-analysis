<?php

namespace App\Data;

class Process
{
    public static function run(string $row)
    {
        $row  = trim($row);
        $row2 = explode(',', $row);

        switch ($row2[0]) {
            case 001:
                return Salesman::get($row);
            case 002:
                return Customer::get($row);
            case 003:
                return Sales::get($row);
        }
    }


}
