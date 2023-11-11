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
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropForeign(['location_id']);
        });
        Schema::table('rooms', function (Blueprint $table) {
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
        });

        Schema::table('room_facilities', function (Blueprint $table) {
            $table->dropForeign(['room_id']);
            $table->dropForeign(['facility_id']);
        });
        Schema::table('room_facilities', function (Blueprint $table) {
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
            $table->foreign('facility_id')->references('id')->on('facilities')->onDelete('cascade');
        });

        Schema::table('guest_waiting_lists', function (Blueprint $table) {
            $table->dropForeign(['room_id']);
            $table->dropForeign(['user_id']);
        });
        Schema::table('guest_waiting_lists', function (Blueprint $table) {
            $table->foreign('user_id')->on('users')->references('id')->onDelete('cascade');
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
        });
        Schema::table('residents', function (Blueprint $table) {
            $table->dropForeign(['room_id']);
            $table->dropForeign(['user_id']);
        });
        Schema::table('residents', function (Blueprint $table) {
            $table->foreign('user_id')->on('users')->references('id')->onDelete('cascade');
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
        });

        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropForeign(['resident_id']);
        });
        Schema::table('testimonials', function (Blueprint $table) {
            $table->foreign('resident_id')->references('id')->on('residents')->onDelete('cascade');
        });

        Schema::table('complaints', function (Blueprint $table) {
            $table->dropForeign(['resident_id']);
        });
        Schema::table('complaints', function (Blueprint $table) {
            $table->foreign('resident_id')->references('id')->on('residents')->onDelete('cascade');
        });

        Schema::table('late_payment_notifications', function (Blueprint $table) {
            $table->dropForeign(['resident_id']);
        });
        Schema::table('late_payment_notifications', function (Blueprint $table) {
            $table->foreign('resident_id')->references('id')->on('residents')->onDelete('cascade');
        });
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['resident_id']);
        });
        Schema::table('payments', function (Blueprint $table) {
            $table->foreign('resident_id')->references('id')->on('residents')->onDelete('cascade');
        });

        Schema::table('room_images', function (Blueprint $table) {
            $table->dropForeign(['room_id']);
        });
        Schema::table('room_images', function (Blueprint $table) {
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
};
