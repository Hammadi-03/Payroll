<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Employee;
use App\Models\Payroll;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public function render()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            // Data untuk Dashboard Admin
            $periodeBulanini = \Carbon\Carbon::now()->locale('id')->isoFormat('MMMM YYYY');
            return view('livewire.dashboard.dashboard', [
                'totalKaryawan' => Employee::count(),
                'totalGaji' => Payroll::where('month_year', $periodeBulanini)->sum('net_salary'),
                'role' => 'admin'
            ])->layout('layouts.app');
        } else {
            // Data untuk Dashboard User (ESS)
            $employee = Employee::where('user_id', $user->id)->first();
            $payHistory = [];
            $yearlySummary = [
                'gross' => 0,
                'deduction' => 0,
                'net' => 0
            ];

            if ($employee) {
                $payHistory = Payroll::where('employee_id', $employee->id)
                    ->orderBy('id', 'desc')
                    ->take(5)
                    ->get();

                // Hitung ringkasan tahunan (Yearly Summary)
                $currentYear = date('Y');
                $yearlyPayrolls = Payroll::where('employee_id', $employee->id)
                    ->where('month_year', 'like', "%$currentYear")
                    ->get();

                foreach ($yearlyPayrolls as $p) {
                    $yearlySummary['gross'] += $p->basic_salary + $p->allowance;
                    $yearlySummary['deduction'] += $p->deduction;
                    $yearlySummary['net'] += $p->net_salary;
                }
            }

            return view('livewire.dashboard.dashboard', [
                'employee' => $employee,
                'payHistory' => $payHistory,
                'yearlySummary' => $yearlySummary,
                'role' => 'user'
            ])->layout('layouts.app');
        }
    }
}
