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
        Schema::create('late_payment_notifications', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('resident_id')->unsigned();
            $table->timestamp('notification_date')->nullable();
            $table->text('notification_content');
            $table->string('read_status', 5);
            $table->timestamps();

            $table->foreign('resident_id')->references('id')->on('residents');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('late_payment_notifications');
    }
};
