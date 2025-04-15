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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('serial_number')->unique();
            $table->string('location');
            $table->string('suburb');
            $table->string('plot_number');
            $table->date('valuation_date');
            $table->string('signing_valuer');
            $table->decimal('market_value', 15, 2);
            $table->decimal('forced_sale_value', 15, 2);
            $table->string('gps_coordinates');
            $table->string('valuing_company');
            $table->string('qr_code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
