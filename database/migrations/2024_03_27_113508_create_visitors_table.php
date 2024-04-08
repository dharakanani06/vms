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
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('gender');
            $table->string('your_company');
            $table->string('national_identification_no');
            $table->text('address');
            $table->unsignedBigInteger('select_employee');
            $table->unsignedBigInteger('purpose_id')->nullable();
            $table->date('visit_date');
            $table->string('visitor_comefrom');
            $table->timestamp('booking_date')->useCurrent();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
      
    }

    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};
