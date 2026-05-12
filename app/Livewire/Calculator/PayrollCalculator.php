<?php

namespace App\Livewire\Calculator;

use Livewire\Component;
use App\Models\Payroll;
use App\Models\Employee;
use Illuminate\Validation\Rule;

class PayrollCalculator extends Component
{   
    // Properti untuk menyimpan input dari form
    public $employee_id = null;
    public $basic_salary = 0;
    public $allowance = 0;
    public $deduction = 0;
    public string $month_year = ''; // user pilih sendiri: "April 2026"


    // Output (dihitung otomatis)
    public $net_salary = 0;

    public function mount ()
    {
        // Default bulan/tahun ke bulan ini (format Indonesia)
        $this->month_year = now()->locale('id')->isoFormat('MMMM YYYY');

    }

    // Lifecycle Hook: hitung ulang THP setiap kali input angka berubah
    public function updated($field)
    {
        if (in_array($field,['basic_salary','allowance','deduction'])) {
            $basic = (int) preg_replace('/[^0-9]/', '', $this->basic_salary ?? '0');
            $allow = (int) preg_replace('/[^0-9]/', '', $this->allowance ?? '0');
            $deduct = (int) preg_replace('/[^0-9]/', '', $this->deduction ?? '0');
            $this->net_salary = max(0, ($basic + $allow) - $deduct);
        }
    }

    public function savePayroll()
    {
        // Bersihkan input angka dari format string sebelum divalidasi
        $this->basic_salary = (int) preg_replace('/[^0-9]/', '', $this->basic_salary ?? '0');
        $this->allowance = (int) preg_replace('/[^0-9]/', '', $this->allowance ?? '0');
        $this->deduction = (int) preg_replace('/[^0-9]/', '', $this->deduction ?? '0');

        // Validasi Input
        $this->validate([
            'employee_id' =>[
                'required',
                'exists:employees,id',
                // Cegah slip gaji duplikat: satu karyawan max satu slip per bulan/tahun
                Rule::unique('payrolls', 'employee_id')->where('month_year', $this->month_year)
            ],
            'basic_salary' => 'required|integer|min:1',
            'month_year' => 'required|string',
        ], [
            'employee_id.required' => 'Pilih karyawan.',
            'employee_id.exists' => 'Karyawan tidak ditemukan.',
            'employee_id.unique' => 'Slip gaji untuk karyawan ini sudah ada di bulan/tahun yang dipilih.',
            'basic_salary.required' => 'Masukkan gaji pokok.',
            'basic_salary.integer' => 'Gaji pokok harus berupa angka.',
            'basic_salary.min' => 'Gaji pokok harus minimal 1.',
            'month_year.required' => 'Pilih bulan dan tahun.',
        ]);

        Payroll::create([
            'employee_id' => $this->employee_id,
            'basic_salary' => $this->basic_salary,
            'allowance' => $this->allowance,
            'deduction' => $this->deduction,
            'net_salary' => $this->net_salary,
            'month_year' => $this->month_year,
        ]);

        session()->flash('success', 'Slip gaji berhasil diterbitkan untuk ' . $this->month_year . '!');
        // Reset form setelah simpan
        $this->reset(['employee_id', 'basic_salary', 'allowance', 'deduction', 'net_salary']);
        //Reset periode ke bulan sekarang — jangan panggil mount() secara manual!
        $this->month_year = \Carbon\Carbon::now()->locale('id')->isoFormat('MMMM YYYY');


    }
    

    public function render()
    {
        return view('livewire.calculator.payroll-calculator', [
            'employees' => Employee::orderBy('name', 'asc')->get(),
        ])->layout('layouts.app');
    }
}
