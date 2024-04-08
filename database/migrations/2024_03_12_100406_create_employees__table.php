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
        // First, create the employees table
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->enum('gender', ['male', 'female']);
            $table->string('phone_number');
            $table->text('address');
            $table->string('country');
            $table->string('city');
            $table->string('state');
            $table->date('date_of_birth');
            $table->string('role');
            $table->string('image')->nullable();
            $table->unsignedBigInteger('added_by')->nullable();
            $table->unsignedBigInteger('org_id')->nullable();
            $table->unsignedBigInteger('departments_id')->nullable();
            $table->unsignedBigInteger('designations_id')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });

        // Add foreign key constraints
        Schema::table('employees', function (Blueprint $table) {
            $table->foreign('departments_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('designations_id')->references('id')->on('designations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
