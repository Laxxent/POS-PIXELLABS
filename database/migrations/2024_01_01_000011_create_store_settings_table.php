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
        Schema::create('store_settings', function (Blueprint $table) {
            $table->id();
            $table->string('store_name');
            $table->text('store_address');
            $table->string('store_phone');
            $table->string('store_email')->nullable();
            $table->string('store_logo')->nullable();
            $table->string('currency', 3)->default('IDR');
            $table->decimal('tax_rate', 5, 2)->default(0);
            $table->boolean('enable_tax')->default(false);
            $table->boolean('enable_barcode')->default(true);
            $table->boolean('enable_serial_number')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_settings');
    }
};

