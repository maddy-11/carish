<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableEmailTemplateDescriptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('email_template_descriptions', function (Blueprint $table) {
            $table->string('subject')->nullable()->change();
            $table->binary('content')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('email_template_descriptions', function (Blueprint $table) {
            $table->string('subject')->change();
            $table->binary('content')->change();
        });
    }
}
