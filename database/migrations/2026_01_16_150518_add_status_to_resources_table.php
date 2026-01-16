<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('resources', function (Blueprint $table) {
        // Adds a 'status' column that defaults to 'available'
        // We place it after the 'name' column (or whichever column you prefer)
        $table->string('status')->default('available')->after('name'); 
    });
}

public function down()
{
    Schema::table('resources', function (Blueprint $table) {
        $table->dropColumn('status');
    });
}
};
