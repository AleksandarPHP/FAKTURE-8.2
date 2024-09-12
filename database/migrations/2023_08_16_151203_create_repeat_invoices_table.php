<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepeatInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repeat_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->integer('frequency');
            $table->date('date_first_inv');
            $table->date('date_last_inv')->nullable();
            $table->date('date_next_inv')->nullable();
            $table->string('method_of_payment');
            $table->string('operator');
            $table->integer('reference_number');
            $table->bigInteger('jir');
            $table->longText('notes')->nullable();
            $table->longText('email_text');
            $table->string('client_company');
            $table->string('jib');
            $table->integer('client_pdv');
            $table->string('client_adderss');
            $table->string('client_city');
            $table->string('client_email');
            $table->integer('client_individual')->nullable();
            $table->json('goods');
            $table->string('lang');
            $table->integer('suma');
            $table->timestamps('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('repeat_invoices');
    }
}
