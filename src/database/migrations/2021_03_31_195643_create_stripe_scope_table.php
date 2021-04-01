<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStripeScopesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stripe_scopes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        //Core
        \Adsy2010\LaravelStripeWrapper\Models\StripeScope::create(['name'=>'Apple Pay Domains']);
        \Adsy2010\LaravelStripeWrapper\Models\StripeScope::create(['name'=>'Balance']);
        \Adsy2010\LaravelStripeWrapper\Models\StripeScope::create(['name'=>'Balance transaction sources']);
        \Adsy2010\LaravelStripeWrapper\Models\StripeScope::create(['name'=>'Charges']);
        \Adsy2010\LaravelStripeWrapper\Models\StripeScope::create(['name'=>'Customers']);
        \Adsy2010\LaravelStripeWrapper\Models\StripeScope::create(['name'=>'Disputes']);
        \Adsy2010\LaravelStripeWrapper\Models\StripeScope::create(['name'=>'Events']);
        \Adsy2010\LaravelStripeWrapper\Models\StripeScope::create(['name'=>'Files']);
        \Adsy2010\LaravelStripeWrapper\Models\StripeScope::create(['name'=>'PaymentIntents']);
        \Adsy2010\LaravelStripeWrapper\Models\StripeScope::create(['name'=>'PaymentMethods']);
        \Adsy2010\LaravelStripeWrapper\Models\StripeScope::create(['name'=>'Payouts']);
        \Adsy2010\LaravelStripeWrapper\Models\StripeScope::create(['name'=>'Products']);
        \Adsy2010\LaravelStripeWrapper\Models\StripeScope::create(['name'=>'SetupIntents']);
        \Adsy2010\LaravelStripeWrapper\Models\StripeScope::create(['name'=>'Sources']);
        \Adsy2010\LaravelStripeWrapper\Models\StripeScope::create(['name'=>'Tokens']);

        //Checkout
        \Adsy2010\LaravelStripeWrapper\Models\StripeScope::create(['name'=>'Checkout Sessions']);

        //Billing
        \Adsy2010\LaravelStripeWrapper\Models\StripeScope::create(['name'=>'Coupons']);
        \Adsy2010\LaravelStripeWrapper\Models\StripeScope::create(['name'=>'Credit notes']);
        \Adsy2010\LaravelStripeWrapper\Models\StripeScope::create(['name'=>'Customer portal']);
        \Adsy2010\LaravelStripeWrapper\Models\StripeScope::create(['name'=>'Invoices']);
        \Adsy2010\LaravelStripeWrapper\Models\StripeScope::create(['name'=>'Plans']);
        \Adsy2010\LaravelStripeWrapper\Models\StripeScope::create(['name'=>'Subscriptions']);
        \Adsy2010\LaravelStripeWrapper\Models\StripeScope::create(['name'=>'Tax Rates']);
        \Adsy2010\LaravelStripeWrapper\Models\StripeScope::create(['name'=>'Usage Records']);

        //Connect
        \Adsy2010\LaravelStripeWrapper\Models\StripeScope::create(['name'=>'Application Fees']);
        \Adsy2010\LaravelStripeWrapper\Models\StripeScope::create(['name'=>'Login Links']);
        \Adsy2010\LaravelStripeWrapper\Models\StripeScope::create(['name'=>'Account Links']);
        \Adsy2010\LaravelStripeWrapper\Models\StripeScope::create(['name'=>'Top-ups']);
        \Adsy2010\LaravelStripeWrapper\Models\StripeScope::create(['name'=>'Transfers']);

        //Orders
        \Adsy2010\LaravelStripeWrapper\Models\StripeScope::create(['name'=>'Orders']);
        \Adsy2010\LaravelStripeWrapper\Models\StripeScope::create(['name'=>'SKUs']);

        //Issuing
        \Adsy2010\LaravelStripeWrapper\Models\StripeScope::create(['name'=>'Authorizations']);
        \Adsy2010\LaravelStripeWrapper\Models\StripeScope::create(['name'=>'Cardholders']);
        \Adsy2010\LaravelStripeWrapper\Models\StripeScope::create(['name'=>'Cards']);
        \Adsy2010\LaravelStripeWrapper\Models\StripeScope::create(['name'=>'Disputes']);
        \Adsy2010\LaravelStripeWrapper\Models\StripeScope::create(['name'=>'Transactions']);

        //Reporting
        \Adsy2010\LaravelStripeWrapper\Models\StripeScope::create(['name'=>'Report Runs and Report Types']);

        //Webhook
        \Adsy2010\LaravelStripeWrapper\Models\StripeScope::create(['name'=>'Webhook Endpoints']);

        //Stripe CLI
        \Adsy2010\LaravelStripeWrapper\Models\StripeScope::create(['name'=>'Debugging tools']);

        //Basic
        \Adsy2010\LaravelStripeWrapper\Models\StripeScope::create(['name'=>'PUBLISHABLE']);
        \Adsy2010\LaravelStripeWrapper\Models\StripeScope::create(['name'=>'SECRET']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stripe_scope');
    }
}
