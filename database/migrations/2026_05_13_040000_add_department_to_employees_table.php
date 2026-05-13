<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            if (!Schema::hasColumn('employees', 'department')) {
                $table->string('department')->nullable()->after('position');
            }
            if (!Schema::hasColumn('employees', 'basic_salary')) {
                $table->decimal('basic_salary', 15, 2)->default(0)->after('department');
            }
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumnIfExists('department');
        });
    }
};
