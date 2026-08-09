<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBookingFieldsToMessContactTable extends Migration
{
    public function up()
    {
        Schema::table('mess_contact', function (Blueprint $table) {
            if (!Schema::hasColumn('mess_contact', 'type')) {
                $table->string('type', 30)->default('contact')->after('phone');
            }
            if (!Schema::hasColumn('mess_contact', 'booking_date')) {
                $table->date('booking_date')->nullable()->after('type');
            }
            if (!Schema::hasColumn('mess_contact', 'booking_time')) {
                $table->string('booking_time', 20)->nullable()->after('booking_date');
            }
            if (!Schema::hasColumn('mess_contact', 'guests')) {
                $table->unsignedTinyInteger('guests')->nullable()->after('booking_time');
            }
            if (!Schema::hasColumn('mess_contact', 'status')) {
                $table->string('status', 30)->default('new')->after('guests');
            }
        });
    }

    public function down()
    {
        Schema::table('mess_contact', function (Blueprint $table) {
            $columns = [];
            foreach (['type', 'booking_date', 'booking_time', 'guests', 'status'] as $column) {
                if (Schema::hasColumn('mess_contact', $column)) {
                    $columns[] = $column;
                }
            }
            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
}
