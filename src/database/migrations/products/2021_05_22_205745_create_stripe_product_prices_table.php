<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStripeProductPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stripe_product_prices', function (Blueprint $table) {
            $table->string('id')->primary()->unique();
            $table->string('currency', 3);
            $table->string('product'); //id of product
            $table->boolean('active')->nullable();
            $table->json('metadata')->nullable();
            $table->string('nickname')->nullable();
            $table->json('recurring')->nullable();
            $table->string('type')->nullable();
            $table->string('billing_scheme')->nullable();
            $table->boolean('livemode')->nullable();
            $table->string('lookup_key')->nullable();
            $table->json('tiers')->nullable();
            $table->string('tiers_mode')->nullable();
            $table->json('transform_quantity')->nullable();
            $table->timestamp('created')->nullable();
            $table->unsignedInteger('unit_amount')->nullable();
            $table->string('unit_amount_decimal')->nullable();
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
        Schema::dropIfExists('stripe_product_prices');
    }
}
