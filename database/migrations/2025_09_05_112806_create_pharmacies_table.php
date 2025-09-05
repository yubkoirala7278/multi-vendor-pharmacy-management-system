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
        Schema::create('pharmacies', function (Blueprint $table) {
            $table->id();
            // Pharmacy info
            $table->string('name')->unique();

            // DB connection details
            $table->string('db_name')->unique();
            $table->string('db_user');
            $table->string('db_password');

            // Pharmacy admin credentials (stored only in master for quick login switch)
            $table->string('admin_email')->unique();
            $table->string('admin_password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pharmacies');
    }
};
