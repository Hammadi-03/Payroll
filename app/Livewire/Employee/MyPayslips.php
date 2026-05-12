<?php

namespace App\Livewire\Employee;

use Livewire\Component;
use App\Models\Payroll;
use App\Models\Employee;

class MyPayslips extends Component
{
    public $selectedEmployee = '';

    public function render()
    {
        $employees = Employee::orderBy('name')->get();

        $payrolls = collect();
        if ($this->selectedEmployee) {
            $payrolls = Payroll::where('employee_id', $this->selectedEmployee)
                ->orderBy('id', 'desc')
                ->get();
        }

        return view('livewire.employee.my-payslips', [
            'employees' => $employees,
            'payrolls'  => $payrolls,
        ])->layout('layouts.app');
    }
}
