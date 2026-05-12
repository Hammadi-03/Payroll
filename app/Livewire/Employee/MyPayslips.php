<?php

namespace App\Livewire\Employee;

use Livewire\Component;
use App\Models\Payroll;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class MyPayslips extends Component
{
    public function render()
    {
        // Temukan data karyawan yang tertaut dengan akun user ini
        $employee = Employee::where('user_id', Auth::id())->first();

        $payrolls = [];
        if ($employee) {
            $payrolls = Payroll::where('employee_id', $employee->id)
                ->orderBy('id', 'desc')
                ->get();
        }

        return view('livewire.employee.my-payslips', [
            'payrolls' => $payrolls,
            'employee' => $employee
        ])->layout('layouts.app');
    }
}
