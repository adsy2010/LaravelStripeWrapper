<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStripeCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stripe_customers', function (Blueprint $table) {
            $table->string('id')->primary()->unique();
            $table->string('description');
            $table->string('email')->nullable();
            $table->json('metadata')->nullable();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->integer('balance')->nullable();
            $table->timestamp('created');
            $table->string('currency')->nullable();
            $table->string('default_source')->nullable(); //expandable
            $table->boolean('delinquent')->nullable();
            $table->json('discount')->nullable();
            $table->string('invoice_prefix')->nullable();
            $table->boolean('livemode')->nullable();
            $table->integer('next_invoice_sequence')->nullable();
            $table->json('preferred_locales')->nullable();
            $table->string('tax_exempt')->nullable();
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
        Schema::dropIfExists('stripe_customers');
    }
}
