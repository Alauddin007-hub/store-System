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
        Schema::create('binder_details', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('book_id');
            $table->tinyInteger('binder_list_id');
            $table->integer('printing_list_id');
            $table->decimal('received_to_press_order',8,2);
            $table->integer('user_id')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('binder_details');
    }
};
