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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(User::class)->constrained()->restrictOnDelete();
            $table->enum('status', ['pending', 'reserved', 'completed', 'canceled', 'shorted'])->default('pending');
            $table->decimal('total', 15, 2);
            $table->timestamp('status_changed_at')->useCurrent();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
