<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('residents', function (Blueprint $table) {
            $table->string("ktp_number", 17)->nullable();
            $table->string("ktp_image")->nullable();
            $table->string("job", 100)->nullable();
            $table->string("institute", 200)->nullable();
            $table->text("institute_address")->nullable();
            $table->string("vehicle", 10)->nullable();
            $table->string("vehicle_number", 10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('residents', function (Blueprint $table) {
            //
        });
    }
};
