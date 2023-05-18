<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('Invoice_id')->constrained('invoices')->cascadeOnDelete();
            $table->string('Invoice_Number');
            $table->string('Product');
            $table->string('Section');
            $table->string('Status');
            $table->string('Value_Status');
            $table->text('Note')->nullable();
            $table->string('User');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_details');
    }
};
