<?php

namespace App\Http\Controllers;

use App\Data\Customer;
use App\Data\Item;
use App\Data\Process;
use App\Data\Sales;
use App\Data\Salesman;
use App\Http\Upload\File;
use Illuminate\Http\Request;
use App\Models\Salesman as ModelSalesman;
use App\Models\Salesman as ModelCustomer;


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
        $file_process = file(env('STORAGE_IN'). DIRECTORY_SEPARATOR .$filename);
        $processed = [];

        foreach ($file_process as $row) {
            $processed[] = Process::run($row);
        }

        $processed_information = [
            'quantity_salesman'         => ModelSalesman::getQuantity($processed),
            'quantity_customer'         => ModelCustomer::getQuantity($processed),
            'average_salary_of_sellers' => $this->averageSalaryOfSellers($processed),
            'id_best_selling'           => $this->bestSelling($processed),
            'id_worst_seller'           => $this->worstSeller($processed)

        ];


//        echo '<pre>';
//        print_r($processed_information);
//        exit;


        $source  = env('STORAGE_IN'). DIRECTORY_SEPARATOR .$filename;
        $destiny = env('STORAGE_OUT');
        $this->moveFileDone($source, $destiny);

        return view('dashboard.report')
            ->with('processed', $processed_information);
    }

    public function moveFileDone($source, $destiny)
    {
        $info = pathinfo($source);
        $basename = $info['filename'].'.done.'.$info['extension'];
        $to = $destiny . DIRECTORY_SEPARATOR . $basename;
        return rename($source, $to);
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

}