<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParkingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parking', function (Blueprint $table) {
            $table->id();
            $table->string("reg_num");
            $table->enum('category', ['A', 'B', 'C']);
            $table->enum('promo_card', ['silver', 'gold', 'platinum'])->nullable();
            $table->dateTime('arrival_at')->useCurrent();
            $table->dateTime('departure_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parking');
    }
}
