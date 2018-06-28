<?php

namespace App\Http\Controllers;

use function array_column;
use function array_count_values;
use function array_filter;
use function array_keys;
use function array_shift;
use function array_walk;
use function count;
use Exception;
use function explode;
use function fgetcsv;
use function file_get_contents;
use function floatval;
use function fopen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use function number_format;
use function PHPSTORM_META\map;
use function readfile;
use function rename;
use function str_replace;
use function utf8_decode;
use function utf8_encode;
use function view;

class ProcessController extends Controller
{

    public function index()
    {
        $type  = ['dat'];
        $files = [];

        if ($handle = opendir('data/in')) {
            while ($file = readdir( $handle)) {
                $extension = strtolower( pathinfo($file, PATHINFO_EXTENSION));
                if (in_array($extension, $type)) {
                    $files[] = $file;
                }
            }
            closedir($handle);
        }

        return view('dashboard.list')
            ->with('files', $files);
    }

    public function store(Request $request)
    {
        $filename = $request->input('filename');
        $path = 'data/in';

        $file_process = file($path.'/'.$filename);
        $processed = [];

        foreach ($file_process as $row) {
            $processed[] = $this->processLine($row);
        }


        $processed['quantity_salesman'] = $this->getQuantityOfPerson($processed, 'salesman');
        $processed['quantity_customer'] = $this->getQuantityOfPerson($processed, 'customer');

        $processed['average_salary_of_sellers'] = $this->averageSalaryOfSellers($processed);


        echo '<pre>';
        print_r($processed);

        exit;

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

    /**
     *
     * O arquivo processado deve apresentar como resultados:
     *
     * - quantidade de clientes            OK
     * - quantidade de vendedores          OK
     * - a média salarial dos vendedores   OK
     * - o ID da venda mais cara
     * - o pior vendedor
     *
     */

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
        foreach ($processed as $proc) {
            if (isset($proc['sales'])) {

            }
        }
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