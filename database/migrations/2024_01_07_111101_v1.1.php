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
        Schema::create('buss', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');       
            $table->string('name');
            $table->decimal('price', 12, 2)->default(0);
            $table->decimal('discount', 12, 2)->default(0);
            $table->datetime('from_date')->nullable();
            $table->datetime('to_date')->nullable();
            $table->double('time')->default(0);
            $table->json('bus_images')->nullable();
            $table->json('includes')->nullable();
            $table->string('code_from')->nullable();
            $table->string('from');
            $table->string('to');
            $table->string('code_to')->nullable();
            $table->string('logo')->nullable();
            $table->integer('star')->nullable();
            $table->boolean('is_deleted')->default(false); 
            $table->longText('description')->nullable();
           
            $table->timestamps();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
                     
        });

        Schema::create('trains', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            
            $table->string('name');
            $table->decimal('price', 12, 2)->default(0);
            $table->decimal('discount', 12, 2)->default(0);
            $table->datetime('from_date')->nullable();
            $table->datetime('to_date')->nullable();
            $table->double('time')->default(0);
            $table->json('train_images')->nullable();
            $table->json('includes')->nullable();
            $table->string('code_from')->nullable();
            $table->string('from');
            $table->string('to');
            $table->string('code_to')->nullable();
            $table->string('logo')->nullable();
            $table->integer('star')->nullable();
            $table->boolean('is_deleted')->default(false); 
            $table->longText('description')->nullable();
           
            $table->timestamps();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
                     
        });
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            
            $table->string('name');
            $table->decimal('price', 12, 2)->default(0);
            $table->decimal('discount', 12, 2)->default(0);
            $table->datetime('from_date')->nullable();
            $table->datetime('to_date')->nullable();
            $table->double('time')->default(0);
            $table->json('flight_images')->nullable();
            $table->json('includes')->nullable();
            $table->string('code_from')->nullable();
            $table->string('from');
            $table->string('to');
            $table->string('airplane_name')->nullable();
            $table->double('punctuality')->default(0);
            $table->string('airport_from')->nullable();
            $table->string('airport_to')->nullable();
            $table->string('code_to')->nullable();
            $table->string('logo')->nullable();
            $table->integer('star')->nullable();
            $table->boolean('is_deleted')->default(false); 
            $table->longText('description')->nullable();
            $table->longText('info_flight')->nullable();
            $table->timestamps();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
                     
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('bank_name')->unique()->nullable();
            $table->string('account_name')->nullable(); 
            $table->string('account_number')->nullable();
            $table->string('cvv')->nullable(); 
            $table->string('expired_month')->nullable(); 
            $table->string('expired_year')->nullable(); 
            $table->longText('description')->nullable();         
            $table->boolean('is_deleted')->default(false);           
            $table->timestamps();       
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');           
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
