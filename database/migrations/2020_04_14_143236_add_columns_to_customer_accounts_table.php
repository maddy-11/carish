<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToCustomerAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_accounts', function (Blueprint $table) {
              $table->integer('ad_id')->after('customer_id')->nullable();
            $table->string('number_of_days')->after('debit')->nullable();
            $table->string('paid_amount')->after('number_of_days')->nullable();
            $table->string('type')->after('paid_amount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_accounts', function (Blueprint $table) {
            $table->dropColumn('ad_id');
            $table->dropColumn('number_of_days');
            $table->dropColumn('paid_amount');
            $table->dropColumn('type');
        });
    }
}
