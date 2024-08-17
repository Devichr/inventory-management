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
        Schema::create('eoq_calculations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fabric_id')->constrained('fabrics');
            $table->integer('annual_demand');
            $table->decimal('order_cost', 15, 2);
            $table->decimal('holding_cost', 15, 2);
            $table->integer('eoq');
            $table->decimal('total_cost', 15, 2);
            $table->integer('reorder_point');
            $table->date('calculation_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eoq_calculations');
    }
};
