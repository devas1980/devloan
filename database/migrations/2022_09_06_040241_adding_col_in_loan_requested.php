<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddingColInLoanRequested extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loan_requested', function (Blueprint $table) {
            
            $table->string('loan_time_period',4)->nullable();
            $table->string('loan_rate_intrest',2)->default(4);
            $table->date('loan_applied_date');
            $table->date('loan_approval_date');
            $table->string('loan_requested', 100)->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('loan_requested', function (Blueprint $table) {
            //
        });
    }
}
