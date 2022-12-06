<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;


class CustomersExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    use Exportable;

    private $customers;

    public function __construct($customers)
    {
        $this->customers = $customers;
    }

    public function headings(): array
    {
        return [
            'Tên khách hàng',
            'Email',
            'TelNum',
            'Địa chỉ'
        ];
    }
 
    public function collection()
    {
        return  $this->customers;
    }
}
