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
        Schema::create('quinielas', function (Blueprint $table) {
            $table->id();
            $table->enum('type', [1, 2])->default(1);
            $table->float('ticket_price', 8, 2, true);
            $table->json('prize');
            $table->boolean('is_active')->default(true);
            $table->dateTime('close_at');
            $table->boolean('has_three_for_two')->default(true);
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
        Schema::dropIfExists('quinielas');
    }
};
