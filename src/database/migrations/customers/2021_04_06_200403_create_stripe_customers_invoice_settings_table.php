<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStripeCustomersInvoiceSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stripe_customers_invoice_settings', function (Blueprint $table) {
            $table->id();
            $table->string('stripe_customer_id');
            $table->json('custom_fields')->nullable();
            $table->string('default_payment_method')->nullable(); //expandable or use to call separately
            $table->string('footer')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stripe_customers_invoice_settings');
    }
}
