<?php

namespace App\Livewire\Employee;

use Livewire\Component;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class EmployeeManager extends Component
{
    public ?int $employee_id = null;
    public bool $isEditMode  = false;

    // Form fields
    public string $nik        = '';
    public string $name       = '';
    public string $phone      = '';
    public string $position   = '';
    public string $department = '';
    public string $address    = '';
    public string $password   = ''; // Manual password update

    // Generated credentials (shown after creation)
    public ?string $generatedEmail    = null;
    public ?string $generatedPassword = null;
    public bool    $showCredentials   = false;

    // ──────────────────────────────────────────────────────────────
    // Helpers
    // ──────────────────────────────────────────────────────────────

    /**
     * Build a unique @education.id email from an employee name.
     * "Ahmad Pratama" → "ahmad.pratama@education.id"
     * Appends a counter if the address is already taken.
     */
    private function generateEmail(string $name): string
    {
        $parts  = preg_split('/\s+/', trim($name));
        $first  = Str::ascii(strtolower($parts[0] ?? 'staff'));
        $last   = Str::ascii(strtolower(end($parts)));

        // Use "first.last" if name has multiple words, otherwise just first
        $base   = count($parts) > 1 ? "{$first}.{$last}" : $first;
        $base   = preg_replace('/[^a-z0-9.]/', '', $base);

        $email  = "{$base}@education.id";
        $suffix = 1;

        while (User::where('email', $email)->exists()) {
            $email = "{$base}{$suffix}@education.id";
            $suffix++;
        }

        return $email;
    }

    /**
     * Generate a readable but secure 10-char password.
     * e.g.  "Xk7#mQpL2!"
     */
    private function generatePassword(): string
    {
        $upper   = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
        $lower   = 'abcdefghjkmnpqrstuvwxyz';
        $digits  = '23456789';
        $special = '!@#$%&*';

        $password  = $upper[random_int(0, strlen($upper) - 1)];
        $password .= $lower[random_int(0, strlen($lower) - 1)];
        $password .= $digits[random_int(0, strlen($digits) - 1)];
        $password .= $special[random_int(0, strlen($special) - 1)];

        for ($i = 0; $i < 6; $i++) {
            $all      = $upper . $lower . $digits . $special;
            $password .= $all[random_int(0, strlen($all) - 1)];
        }

        return str_shuffle($password);
    }

    // ──────────────────────────────────────────────────────────────
    // Actions
    // ──────────────────────────────────────────────────────────────

    public function store()
    {
        $this->validate([
            'nik'        => 'required|unique:employees,nik,' . $this->employee_id,
            'name'       => 'required|min:3',
            'phone'      => 'required',
            'position'   => 'required',
            'department' => 'required',
            'address'    => 'required|min:5',
        ], [
            'nik.required'        => 'NIK wajib diisi.',
            'nik.unique'          => 'NIK sudah digunakan karyawan lain.',
            'name.required'       => 'Nama wajib diisi.',
            'name.min'            => 'Nama minimal 3 karakter.',
            'phone.required'      => 'No. Telepon wajib diisi.',
            'position.required'   => 'Jabatan wajib dipilih.',
            'department.required' => 'Departemen wajib dipilih.',
            'address.required'    => 'Alamat wajib diisi.',
            'address.min'         => 'Alamat minimal 5 karakter.',
        ]);

        DB::transaction(function () {
            if ($this->isEditMode) {
                // ── UPDATE ──────────────────────────────────────────
                $emp = Employee::findOrFail($this->employee_id);
                $emp->update([
                    'nik'        => $this->nik,
                    'name'       => $this->name,
                    'phone'      => $this->phone,
                    'position'   => $this->position,
                    'department' => $this->department,
                    'address'    => $this->address,
                ]);

                // Also update user info
                if ($emp->user_id) {
                    $userData = ['name' => $this->name];
                    
                    // If a new password is provided, update it
                    if (!empty($this->password)) {
                        $userData['password'] = Hash::make($this->password);
                    }
                    
                    User::where('id', $emp->user_id)->update($userData);
                }

                session()->flash('success', 'Data karyawan berhasil diperbarui.');
                $this->password = ''; // Clear password field
                $this->showCredentials = false;
            } else {
                // ── CREATE ──────────────────────────────────────────
                $email    = $this->generateEmail($this->name);
                $password = $this->generatePassword();

                // Create the User account first
                $user = User::create([
                    'name'     => $this->name,
                    'email'    => $email,
                    'password' => Hash::make($password),
                    'role'     => 'user',
                ]);

                // Create the Employee record, linked to the user
                Employee::create([
                    'nik'        => $this->nik,
                    'name'       => $this->name,
                    'phone'      => $this->phone,
                    'position'   => $this->position,
                    'department' => $this->department,
                    'address'    => $this->address,
                    'user_id'    => $user->id,
                ]);

                // Expose credentials for admin to copy
                $this->generatedEmail    = $email;
                $this->generatedPassword = $password;
                $this->showCredentials   = true;

                session()->flash('success', 'Karyawan berhasil ditambahkan dan akun login telah dibuat!');
            }
        });

        $this->resetForm(keepCredentials: true);
    }

    public function edit(int $id)
    {
        $emp = Employee::findOrFail($id);
        $this->employee_id = $emp->id;
        $this->nik         = $emp->nik;
        $this->name        = $emp->name;
        $this->phone       = $emp->phone;
        $this->position    = $emp->position;
        $this->department  = $emp->department ?? '';
        $this->address     = $emp->address;
        $this->isEditMode  = true;
        $this->showCredentials = false;
    }

    public function delete(int $id)
    {
        $emp = Employee::findOrFail($id);

        // Also delete the linked user account
        if ($emp->user_id) {
            User::find($emp->user_id)?->delete();
        }

        $emp->delete();
        session()->flash('success', 'Karyawan dan akun login berhasil dihapus.');
    }

    public function resetPassword(int $id)
    {
        $emp = Employee::findOrFail($id);
        if (!$emp->user_id) {
            session()->flash('error', 'Karyawan ini belum memiliki akun.');
            return;
        }

        $newPassword = $this->generatePassword();
        User::where('id', $emp->user_id)->update(['password' => Hash::make($newPassword)]);

        $user = User::find($emp->user_id);

        $this->generatedEmail    = $user->email;
        $this->generatedPassword = $newPassword;
        $this->showCredentials   = true;

        session()->flash('success', 'Password berhasil direset!');
    }

    public function dismissCredentials()
    {
        $this->showCredentials   = false;
        $this->generatedEmail    = null;
        $this->generatedPassword = null;
    }

    public function resetForm(bool $keepCredentials = false)
    {
        $this->reset(['employee_id', 'nik', 'name', 'phone', 'position', 'department', 'address', 'password', 'isEditMode']);
        $this->resetValidation();

        if (!$keepCredentials) {
            $this->showCredentials   = false;
            $this->generatedEmail    = null;
            $this->generatedPassword = null;
        }
    }

    // ──────────────────────────────────────────────────────────────
    // Render
    // ──────────────────────────────────────────────────────────────

    public function render()
    {
        return view('livewire.employee.employee-manager', [
            'employees' => Employee::with('user')->orderBy('id', 'desc')->get(),
        ])->layout('layouts.app');
    }
}
