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
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->string('name', 15);
            $table->string('breed', 50);
            $table->char('sex', 1);
            $table->float('weight', 7);
            $table->string('age', 10);
            $table->string('picture_1');
            $table->string('picture_2');
            $table->string('description', 128)->nullable();
            $table->boolean('adopted');
            $table->foreignId('animal_size_id')->constrained('animal_sizes');
            $table->foreignId('species_id')->constrained('species');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('address_id')->constrained('addresses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('animals');
    }
};
