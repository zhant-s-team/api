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
        Schema::table('entregas', function (Blueprint $table) {
            $table->unsignedBigInteger('accept_by')->nullable()->after('status');
            $table->foreign('accept_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('entregas', function (Blueprint $table) {
            $table->dropForeign(['accept_by']);
            $table->dropColumn('accept_by');
        });
    }
};
