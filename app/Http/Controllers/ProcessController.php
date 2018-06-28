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
use App\Models\Customer as ModelCustomer;
use App\Models\Sales as ModelSales;

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
            'average_salary_of_sellers' => ModelSalesman::averageSalaryOfSellers($processed),
            'id_best_selling'           => ModelSales::bestSelling($processed),
            'id_worst_seller'           => ModelSales::worstSeller($processed)
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
}