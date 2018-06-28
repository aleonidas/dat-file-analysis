<?php

namespace App\Http\Controllers;

use App\Http\Upload\File;
use Illuminate\Http\Request;


class ProcessController extends Controller
{

    public function index(File $file)
    {
        return view('dashboard.list')
            ->with('files', $file->getFilesDirIn());
    }

    public function store(Request $request)
    {
        $filename = $request->input('filename');
        $path = env('STORAGE_IN');

        $file_process = file($path.'/'.$filename);
        $processed = [];

        foreach ($file_process as $row) {
            $processed[] = $this->processLine($row);
        }


        $processed['quantity_salesman'] = $this->getQuantityOfPerson($processed, 'salesman');
        $processed['quantity_customer'] = $this->getQuantityOfPerson($processed, 'customer');
        $processed['average_salary_of_sellers'] = $this->averageSalaryOfSellers($processed);
        $processed['id_best_selling'] = $this->bestSelling($processed);
        $processed['id_worst_seller'] = $this->worstSeller($processed);


        $source  = 'data/in/'.$filename;
        $destiny = 'data/out/';
        $this->moveFileDone($source, $destiny);

        return view('dashboard.report')
            ->with('processed', $processed);
    }

    public function moveFileDone($source, $destiny)
    {
        $info = pathinfo($source);
        $basename = $info['filename'].'.done.'.$info['extension'];
        $to = $destiny . DIRECTORY_SEPARATOR . $basename;
        return rename($source, $to);
    }

    public function getQuantityOfPerson($processed, $person)
    {
        $quantity = 0;
        foreach ($processed as $proc) {
            if (isset($proc[$person])) {
                $quantity++;
            }
        }

        return $quantity;
    }


    public function averageSalaryOfSellers($processed)
    {
        $quantity_salesman = $this->getQuantityOfPerson($processed, 'salesman');
        $total_salary = 0;

        foreach ($processed as $proc) {
            if (isset($proc['salesman'])) {
                $total_salary += floatval($proc['salesman']['salary']);
            }
        }

        return number_format(($total_salary / $quantity_salesman), 2, '.', '');
    }

    public function bestSelling($processed)
    {
        $sale_id = null;
        $sale_total = 0;

        foreach ($processed as $proc) {
            if (isset($proc['sales'])) {
                if ($proc['sales']['total'] > $sale_total) {
                    $sale_total = $proc['sales']['total'];
                    $sale_id   = $proc['sales']['sale_id'];
                }
            }
        }

        return $sale_id;
    }

    public function worstSeller($processed)
    {
        $salesman_id = null;
        $sale_total = null;

        foreach ($processed as $proc) {
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


    public function processLine($row)
    {
        $row = trim($row);
        $row2 = explode(',', $row);

        switch ($row2[0]) {
            case 001:
                return $this->getSalesman($row);
            case 002:
                return $this->getCustomer($row);
            case 003:
                return $this->getSales($row);
        }
    }

    public function getSalesman($row)
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

    public function getCustomer($row)
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

    public function getSales($row)
    {
        $items = $this->getItems($row);
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

    public function getItems($row)
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