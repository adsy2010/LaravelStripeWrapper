<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStripeProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stripe_products', function (Blueprint $table) {
            $table->string('id')->primary()->unique();
            $table->string('name');
            $table->string('description')->nullable();
            $table->boolean('active')->nullable();
            $table->timestamp('created')->nullable();
            $table->timestamp('updated')->nullable();
            $table->json('images')->nullable();
            $table->boolean('livemode')->nullable();
            $table->json('metadata')->nullable();
            $table->json('package_dimensions')->nullable();
            $table->boolean('shippable')->nullable();
            $table->string('statement_descriptor')->nullable();
            $table->string('unit_label')->nullable();
            $table->string('url')->nullable();
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
        Schema::dropIfExists('stripe_products');
    }
}
