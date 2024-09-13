<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
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
            $table->string('type');
            $table->string('prefix')->nullable();
            $table->integer('inv_number')->nullable();
            $table->year('year')->nullable();
            $table->integer('fiscal_number')->nullable();
            $table->integer('suma')->nullable();
            $table->string('suffix')->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->date('date_of_payment')->nullable();
            $table->date('delivery_date')->nullable();
            $table->string('method_of_payment')->nullable();
            $table->string('operator')->nullable();
            $table->integer('reference_number')->nullable();
            $table->integer('jir')->nullable();
            $table->boolean('issued')->default(false);
            $table->integer('status')->nullable();
            $table->integer('sent')->nullable();
            $table->longText('notes')->nullable();
            $table->longText('email_text')->nullable();
            $table->string('client_company')->nullable();
            $table->integer('jib')->nullable();
            $table->integer('client_pdv')->nullable();
            $table->string('client_address')->nullable();
            $table->string('client_city')->nullable();
            $table->string('client_postal_code')->nullable();
            $table->string('client_email')->nullable();
            $table->longText('goods')->nullable();
            $table->string('lang');
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
        Schema::dropIfExists('invoices');
    }
}
