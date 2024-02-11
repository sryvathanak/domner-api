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
        Schema::create('address', function (Blueprint $table) {
            $table->id();
            $table->string('country')->nullable();
            $table->string('province')->nullable();          
            $table->string('city')->nullable();
            $table->string('district')->nullable();
            $table->string('commune')->nullable();
            $table->string('village')->nullable();
            $table->text('street')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('image_place');
            $table->boolean('is_deleted')->default(false);           
            $table->timestamps();                  
        });

        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name'); 
            $table->longText('description')->nullable();         
            $table->boolean('is_deleted')->default(false);           
            $table->timestamps();                  
        });

        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('address_id');
            $table->string('name');
            $table->date('request_date')->nullable(); 
            $table->date('effective_date')->nullable(); 
            $table->decimal('charge', 12, 2)->default(0);
            $table->date('pay_in_month')->nullable();
            $table->date('contract_from')->nullable();
            $table->date('contract_to')->nullable();
            $table->decimal('pay', 12, 2)->default(0);
            $table->decimal('amount_pay', 12, 2)->default(0);
            $table->decimal('remaining', 12, 2)->default(0);
            $table->string('username')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone_number')->unique();
            $table->string('logo')->nullable();
            $table->boolean('is_deleted')->default(false); 
            $table->longText('description')->nullable();
            $table->timestamps();
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->foreign('address_id')->references('id')->on('address')->onDelete('cascade');         
        });



        Schema::create('stays', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('address_id');
            $table->string('name');
            $table->string('bed')->nullable();
            $table->decimal('price', 12, 2)->default(0);
            $table->decimal('discount', 12, 2)->default(0);
            $table->json('hotel_images')->nullable();
            $table->json('room_images')->nullable();
            $table->json('offers')->nullable();
            $table->integer('star')->nullable();
            $table->boolean('is_deleted')->default(false); 
            $table->longText('description')->nullable();
            $table->timestamps();
            $table->longText('policy')->nullable();
            $table->longText('role')->nullable();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('address_id')->references('id')->on('address')->onDelete('cascade');         
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
