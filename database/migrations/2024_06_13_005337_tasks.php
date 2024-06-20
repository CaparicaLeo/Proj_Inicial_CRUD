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
        Schema::create('table_tasks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('name', 50);
            $table->string('title', 50);
            $table->string('description', 255)->nullable();
            $table->string('category',50);
            $table->boolean('status');
            $table->timestamps();

            //Restrição
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_tasks');
    }
};