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
        Schema::create('loginlogs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->text('token'); // Assuming this references another table's primary key
            $table->unsignedBigInteger('org_id')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->dateTime('login_timedate');
            $table->dateTime('logout_timedate')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loginlogs');
    }
};
