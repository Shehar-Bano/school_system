<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('finance_recodes', function (Blueprint $table) {
            $table->enum('status', ['active', 'inactive', 'deleted'])->default('inactive')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('finance_recodes', function (Blueprint $table) {
            //
        });
    }
};
