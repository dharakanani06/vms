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
        Schema::create('vms_users', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('password')->bcrypt();
            $table->string('email')->unique()->nullable();
            $table->string('mobile')->nullable();
            $table->string('designation')->nullable();
            $table->string('role')->nullable();
            $table->unsignedBigInteger('org_id');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vms_users');

    }
};
