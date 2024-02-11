<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('payment_method')->nullable();
        });

        Schema::table('books', function (Blueprint $table) {
            $table->boolean('cancell')->default(false);
        });
        Schema::table('stays', function (Blueprint $table) {
            $table->longText('stay_info')->nullable();
        });
        Schema::table('buss', function (Blueprint $table) {
            $table->longText('bus_info')->nullable();
        });
        Schema::table('trains', function (Blueprint $table) {
            $table->longText('train_info')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
