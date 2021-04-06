<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStripeCredentialScopesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stripe_credential_scopes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stripe_credential_id');
            $table->foreignId('stripe_scope_id');
            $table->string('access', 1); //r,w,n
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
        Schema::dropIfExists('stripe_credential_scopes');
    }
}
