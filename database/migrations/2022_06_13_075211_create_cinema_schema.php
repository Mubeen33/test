<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCinemaSchema extends Migration
{
    /** ToDo: Create a migration that creates all tables for the following user stories

    For an example on how a UI for an api using this might look like, please try to book a show at https://in.bookmyshow.com/.
    To not introduce additional complexity, please consider only one cinema.

    Please list the tables that you would create including keys, foreign keys and attributes that are required by the user stories.

    ## User Stories

     **Movie exploration**
     * As a user I want to see which films can be watched and at what times
     * As a user I want to only see the shows which are not booked out

     **Show administration**
     * As a cinema owner I want to run different films at different times
     * As a cinema owner I want to run multiple films at the same time in different showrooms

     **Pricing**
     * As a cinema owner I want to get paid differently per show
     * As a cinema owner I want to give different seat types a percentage premium, for example 50 % more for vip seat

     **Seating**
     * As a user I want to book a seat
     * As a user I want to book a vip seat/couple seat/super vip/whatever
     * As a user I want to see which seats are still available
     * As a user I want to know where I'm sitting on my ticket
     * As a cinema owner I dont want to configure the seating for every show
     */
    public function up()
    {
        // throw new \Exception('implement in coding task 4, you can ignore this exception if you are just running the initial migrations.');
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->timestamps();
        });
    
        Schema::create('shows', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('movie_id');
            $table->dateTime('showtime');
            $table->boolean('is_booked_out')->default(false);
            $table->timestamps();
    
            $table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');
        });
    
        Schema::create('showrooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
    
        Schema::create('pricing', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('show_id');
            $table->decimal('price', 8, 2);
            $table->timestamps();
    
            $table->foreign('show_id')->references('id')->on('shows')->onDelete('cascade');
        });
    
        Schema::create('seat_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('premium_percentage', 5, 2);
            $table->timestamps();
        });
    
        Schema::create('seats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('showroom_id');
            $table->unsignedBigInteger('seat_type_id');
            $table->boolean('is_booked')->default(false);
            $table->timestamps();
            // seats table have 2 foregin keys
            $table->foreign('showroom_id')->references('id')->on('showrooms')->onDelete('cascade');
            $table->foreign('seat_type_id')->references('id')->on('seat_types')->onDelete('cascade');
        });
    
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('show_id');
            $table->unsignedBigInteger('seat_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
            // booking table have 2 foregin keys
            $table->foreign('show_id')->references('id')->on('shows')->onDelete('cascade');
            $table->foreign('seat_id')->references('id')->on('seats')->onDelete('cascade');
            
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
}
