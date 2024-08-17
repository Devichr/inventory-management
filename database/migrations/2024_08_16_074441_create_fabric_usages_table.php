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
        Schema::create('fabric_usages', function (Blueprint $table) {
        $table->id();
        $table->foreignId('fabric_id')->constrained('fabrics');
        $table->integer('quantity_used');
        $table->date('date');
        $table->integer('remaining_stock');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fabric_usages');
    }
};
