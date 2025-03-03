<?php

use App\Models\User;
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
        Schema::create('one_time_passwords', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignIdFor(User::class)->constrained()->onDelete('cascade');

            $table->string('code');
            $table->unsignedTinyInteger('attempts')->default(0);
            $table->unsignedTinyInteger('status')->default(0);
            $table->ipAddress();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('one_time_passwords');
    }
};
