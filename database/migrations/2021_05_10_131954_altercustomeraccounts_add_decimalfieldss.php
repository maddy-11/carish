<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AltercustomeraccountsAddDecimalfieldss extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
        {
            Schema::table('customer_accounts', function (Blueprint $table) { 
                $table->decimal('credit')->default('0.00')->after('ad_id');
                $table->decimal('debit')->default('0.00')->after('credit');
                $table->decimal('paid_amount')->default('0.00')->after('debit');
            });
        }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
