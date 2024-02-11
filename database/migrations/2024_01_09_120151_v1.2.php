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


        Schema::create('arrange_tours', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            
            $table->string('company_name');
            $table->decimal('price', 12, 2)->default(0);
            $table->decimal('discount', 12, 2)->default(0);
            $table->datetime('from_date')->nullable();
            $table->datetime('to_date')->nullable();
            $table->double('day')->default(0);
            $table->json('trip_images')->nullable();
            $table->json('trip_videos')->nullable();
            $table->json('includes')->nullable();
            $table->json('places')->nullable();
            $table->integer('member')->nullable();
            
            $table->string('logo')->nullable();
            $table->integer('star')->nullable();
            $table->boolean('is_deleted')->default(false); 
            $table->longText('description')->nullable();
            $table->longText('about_tour')->nullable();
            $table->timestamps();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
                     
        });

        Schema::create('my_favorites', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('stay_id')->nullable();
            $table->unsignedBigInteger('trip_id')->nullable();
            $table->boolean('like')->default(false); 
            $table->boolean('is_deleted')->default(false);           
            $table->timestamps();       
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('stay_id')->references('id')->on('stays')->onDelete('cascade');
            $table->foreign('trip_id')->references('id')->on('arrange_tours')->onDelete('cascade');           
        });

        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('stay_id');
            $table->unsignedBigInteger('bus_id');
            $table->unsignedBigInteger('flight_id');
            $table->unsignedBigInteger('train_id');
            $table->unsignedBigInteger('trip_id');
            $table->unsignedBigInteger('payment_id');
            $table->datetime('check_in')->nullable();
            $table->datetime('check_out')->nullable();

            
            $table->decimal('total_price', 12, 2)->default(0);
            $table->double('day')->default(0);
            $table->integer('member')->nullable();
            $table->integer('children')->nullable();
            $table->integer('age')->nullable();
            $table->integer('star')->nullable();
            $table->boolean('is_deleted')->default(false); 
            $table->longText('description')->nullable();
            $table->longText('comment')->nullable();
            
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('stay_id')->references('id')->on('stays')->onDelete('cascade');
            $table->foreign('train_id')->references('id')->on('trains')->onDelete('cascade');
            $table->foreign('bus_id')->references('id')->on('buss')->onDelete('cascade');
            $table->foreign('flight_id')->references('id')->on('flights')->onDelete('cascade');
            $table->foreign('trip_id')->references('id')->on('arrange_tours')->onDelete('cascade');
            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade');
                     
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
