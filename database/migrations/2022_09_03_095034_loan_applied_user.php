<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LoanAppliedUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_requested', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->double('loan_amount',20,2);
            $table->integer('emis');
            $table->tinyinteger('loanstatus')->default(0)->comment('0-Proccess, 1-Approved,2-Rejected');
            $table->text('ReasonRejection')->nullable();
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
        Schema::dropIfExists('loan_requested');
    }
}
