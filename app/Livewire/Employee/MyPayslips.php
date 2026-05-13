<?php

namespace App\Livewire\Employee;

use Livewire\Component;
use App\Models\Payroll;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class MyPayslips extends Component
{
    public $selectedEmployee = '';

    public function mount()
    {
        // If the logged-in user is NOT admin, lock them to their own employee record
        if (Auth::user()->role !== 'admin') {
            $employee = Employee::where('user_id', Auth::id())->first();
            $this->selectedEmployee = $employee?->id ?? '';
        }
    }

    public function render()
    {
        $user    = Auth::user();
        $isAdmin = $user->role === 'admin';

        // Admin: can pick any employee from dropdown
        // Staff: only their own employee record
        if ($isAdmin) {
            $employees = Employee::orderBy('name')->get();
        } else {
            $employees = Employee::where('user_id', $user->id)->get();
        }

        $payrolls = collect();
        if ($this->selectedEmployee) {
            $query = Payroll::where('employee_id', $this->selectedEmployee)
                ->orderBy('id', 'desc');

            // Extra security: non-admins can only query their OWN employee_id
            if (!$isAdmin) {
                $myEmployee = Employee::where('user_id', Auth::id())->first();
                if (!$myEmployee || (int)$this->selectedEmployee !== $myEmployee->id) {
                    abort(403, 'Akses ditolak.');
                }
            }

            $payrolls = $query->get();
        }

        return view('livewire.employee.my-payslips', [
            'employees' => $employees,
            'payrolls'  => $payrolls,
            'isAdmin'   => $isAdmin,
        ])->layout('layouts.app');
    }
}
