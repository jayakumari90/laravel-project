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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('position')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('country')->nullable();
            $table->string('phone',12)->nullable();
            $table->string('zipcode',6)->nullable();
            $table->string('lead_value')->nullable();
            $table->string('company')->nullable();
            $table->string('description')->nullable();
            $table->tinyInteger('lead_public'); 
            $table->tinyInteger('contacted_today'); 
            $table->tinyInteger('status'); 
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
