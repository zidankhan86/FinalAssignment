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
        Schema::create('attendences', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->default(1);
            $table->time('in_time');
            $table->time('out_time')->nullable();
            $table->date('date');
            $table->string('status')->nullable();
            $table->time('hour')->nullable();
            
            
            $table->rememberToken();
            $table->timestamps();
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
