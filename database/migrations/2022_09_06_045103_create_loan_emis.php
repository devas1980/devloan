<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanEmis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_emis', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned();
            $table->bigInteger('loan_id')->constrained();
            $table->float('emi_amount', 10, 0)->nullable();
            $table->date('emi_due_date');
            $table->date('emi_payment_date');
            $table->boolean('emi_payment_status')->default(0);
            $table->text('emi_payment_detils', 65535)->nullable();
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
        //Schema::dropIfExists('loan_emis');
    }
}
