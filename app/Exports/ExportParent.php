<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Models\User;

class ExportParent implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */ 
    public function headings(): array
    {
        return [
            'Parent Name',
            'Email',
            'Gender',
            'Mobile Number',
            'Occupation',
            'Address',
            'Status',
            'Created Date',
        ];
    }
    public function map($value): array
    {
   
        $created_at = !empty($value['created_at']) ? date('d/m/Y', strtotime($value['created_at'])) : '';
        
        $status = ($value['status'] == 0) ? "Active" : "Inactive";
    
        return [
            $value['name'] . ' ' . $value['last_name'],
            $value['email'],
            $value['gender'],
            $value['mobile_number'],
            $value['occupation'],
            $value['address'],
            $status,
            $created_at,
        ];
    }
    public function collection()
    {
        $remove_pagination = 1;
        return User::getParent($remove_pagination);
    }
}
