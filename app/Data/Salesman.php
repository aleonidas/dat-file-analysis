<?php

namespace App\Data;

class Salesman implements InterfaceData
{

    public static function get(string $row)
    {
        $row = explode(',', $row);
        return [
            'salesman' => [
                'id'     => $row[0],
                'cpf'    => $row[1],
                'name'   => $row[2],
                'salary' => $row[3]
            ]
        ];
    }

}