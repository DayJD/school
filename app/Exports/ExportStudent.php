<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Models\User;


class ExportStudent implements FromCollection, WithMapping, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */


    public function headings(): array
    {
        return [
            'Student Name',
            'Parent Name',
            'Email',
            'Admission Number',
            'Roll Number',
            'Class',
            'Gender',
            'Date of Birth',
            'Caste',
            'Religion',
            'Mobile Number',
            'Admission Date',
            'Blood Group',
            'Height',
            'Weight',
            'Status',
            'Created Date',
        ];
    }
    public function map($value): array
    {
        // dd($value);
        $date_of_birth = '';
        if (!empty($value->date_of_birth)) {
            $date_of_birth =  date('d/m/Y', strtotime($value->date_of_birth));
        }
        $admission_date = '';
        if (!empty($value->admission_date)) {
            $admission_date = date('d/m/Y', strtotime($value->admission_date));
        }
        $created_at = '';
        if (!empty($value->created_at)) {
            $created_at = date('d/m/Y', strtotime($value->created_at));
        }
        return [

            $value->name . ' ' . $value->last_name,
            $value->parent_name . ' ' . $value->parent_last_name,
            $value->email,
            $value->admission_number,
            $value->roll_number,
            $value->class_name,
            $value->gender,
            $date_of_birth,
            $value->caste,
            $value->religion,
            $value->mobile_number,
            $admission_date,
            $value->blood_group,
            $value->weight,
            $value->height,
            $value->status,
            $created_at,
        ];
    }
    public function collection()
    {
        $remove_pagination = 1;
        return User::getStudent($remove_pagination);
    }
}
