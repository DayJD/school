<?php

namespace App\Exports;

use App\Models\StudentAttendanceModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportAttendence implements FromCollection, WithMapping, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function headings(): array
    {
        return [
            'Student ID',
            'Student Name',
            'Attendance',
            'Class Name',
            'Created By',
            'Attendance Date',
            'Created Date',
        ];
    }
    public function map($value): array
    {
        // dd($value);
        $attendance_type = '';
        if ($value->attendance_type == 1)
            $attendance_type = 'Present';
        elseif ($value->attendance_type == 2)
            $attendance_type = 'Late';
        elseif ($value->attendance_type == 3)
            $attendance_type = 'Absent';
        elseif ($value->attendance_type == 4)
            $attendance_type = 'Half Day';
        else {
            $attendance_type = 'Unknown';
        }
        return [
            $value->student_id,
            $value->student_name . ' ' . $value->student_last_name,
            $value->class_name,
            $attendance_type,
            $value->created_name,
            date('d/m/Y', strtotime($value->attendance_date)),
            date('d/m/Y', strtotime($value->created_at)),
        ];
    }
    public function collection()
    {
        $remove_pagination = 1;
        return StudentAttendanceModel::getRecord($remove_pagination);
    }
}
