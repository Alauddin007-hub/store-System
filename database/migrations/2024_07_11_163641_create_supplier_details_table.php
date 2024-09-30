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
        Schema::create('supplier_details', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('book_id');
            $table->string('printing_press_name');
            $table->integer('order_printing_press');
            $table->string('send_to_binder_name');
            $table->integer('supplied_from_Binder');
            $table->integer('rest_of_supply');
            $table->integer('created_by')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_details');
    }
};
