<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('details', function (Blueprint $table) {
            $table->id();
            $table->string('bank_name');
            $table->string('bank_account');
            $table->string('SWIFT')->unique();
            $table->string('bank_acc')->nullable();
            $table->string('alternative_payment');
            $table->string('alternative_payment_acc');
            $table->string('alternative_payment2')->unique();
            $table->string('alternative_payment_acc2');
            $table->string('PDV');
            $table->string('include_pdv');
            $table->rememberToken();
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
        Schema::dropIfExists('details');
    }
}
