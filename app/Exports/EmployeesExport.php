<?php

namespace App\Exports;

use App\Models\Employee\Employee;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class EmployeesExport implements FromView
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function view(): View
    {
        return view('backend.employee.download', [
            'employees' => Employee::all()
        ]);
    }
}
