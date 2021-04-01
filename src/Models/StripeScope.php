<?php

namespace Adsy2010\LaravelStripeWrapper\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StripeScope extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    const APPLE_PAY_DOMAINS = 1;
    const BALANCE = 2;
    const BALANCE_TRANSACTION_SOURCES = 3;
    const CHARGES = 4;
    const CUSTOMERS = 5;
    const DISPUTES = 6;
    const EVENTS = 7;
    const FILES = 8;
    const PAYMENTINTENTS = 9;
    const PAYMENTMETHODS = 10;
    const PAYOUTS = 11;
    const PRODUCTS = 12;
    const SETUPINTENTS = 13;
    const SOURCES = 14;
    const TOKENS = 15;
    const CHECKOUT_SESSIONS = 16;
    const COUPONS = 17;
    const CREDIT_NOTES = 18;
    const CUSTOMER_PORTAL = 19;
    const INVOICES = 20;
    const PLANS = 21;
    const SUBSCRIPTIONS = 22;
    const TAX_RATES = 23;
    const USAGE_RECORDS = 24;
    const APPLICATION_FEES = 25;
    const LOGIN_LINKS = 26;
    const ACCOUNT_LINKS = 27;
    const TOP_UPS = 28;
    const TRANSFERS = 29;
    const ORDERS = 30;
    const SKUS = 31;
    const AUTHORIZATIONS = 32;
    const CARDHOLDERS = 33;
    const CARDS = 34;
    const ISSUING_DISPUTES = 35;
    const TRANSACTIONS = 36;
    const REPORT_RUNS_AND_REPORT_TYPES = 37;
    const WEBHOOK_ENDPOINTS = 38;
    const DEBUGGING_TOOLS = 39;
    const PUBLISHABLE = 40;
    const SECRET = 41;

}
