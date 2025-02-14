<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cliente_fornecedor', function (Blueprint $table) {
            $table->dropColumn('idade');
            $table->date('data_nascimento')->nullable()->after('email');
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cliente_fornecedor', function (Blueprint $table) {
            $table->dropColumn('data_nascimento');
            $table->int('idade');
        });
    }
};
