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

    public function store(Request $request, File $file)
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

        $file->moveFileDone($filename);

        return view('dashboard.report')
            ->with('processed', $processed_information);
    }

}