<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Models\User;

class ExportTeacher implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
   
    public function headings(): array
    {
        return [
            'Teacher Name',
            'Email',
            'Gender',
            'Date of Birth',
            'Date of Joining',
            'Mobile Number',
            'Marital Status',
            'Current Address',
            'Permanent Address',
            'Qualification',
            'Work Experience',
            'Note',
            'Status',
            'Created Date',
        ];
    }
    public function map($value): array
    {
        $date_of_birth = '';
        if (!empty($value['date_of_birth'])) {
            $date_of_birth = date('d/m/Y', strtotime($value['date_of_birth']));
        }
    
        $admission_date = '';
        if (!empty($value['admission_date'])) {
            $admission_date = date('d/m/Y', strtotime($value['admission_date']));
        }
    
        $created_at = '';
        if (!empty($value['created_at'])) {
            $created_at = date('d/m/Y', strtotime($value['created_at']));
        }
        $status = ($value->status == 0) ? "Active" : "Inactive";
        return [
            $value['name'] . ' ' . $value['last_name'],
            $value['email'],
            $value['gender'],
            $date_of_birth,
            $admission_date,
            $value['mobile_number'],
            $value['marital_status'],
            $value['address'],
            $value['permanent_address'],
            $value['qualification'],
            $value['work_experience'],
            $value['note'],
            $status ,
            $created_at,
        ];
    }
    public function collection()
    {
        $remove_pagination = 1;
        return User::getTeacher($remove_pagination);
    }
}
