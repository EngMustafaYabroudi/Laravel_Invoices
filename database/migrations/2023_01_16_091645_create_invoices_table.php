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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('Invoice_Number');
            $table->date('Invoice_Date')->nullable();
            $table->date('Due_Date')->nullable();
            $table->date('Payment_Date')->nullable();
            $table->foreignId('Section_id')->constrained('sections')->cascadeOnDelete();
            $table->string('Product');
            $table->string('Discount');
            $table->decimal('Amount_Collection',8,2)->nullable();
            $table->decimal('Amount_Commission');
            $table->string('Rate_VAT');
            $table->decimal('Value_VAT',8,2);
            $table->decimal('Total',8,2);
            $table->string('Status',50);
            $table->integer('Value_Status');
            $table->text('Note')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('invoices');
    }
};
