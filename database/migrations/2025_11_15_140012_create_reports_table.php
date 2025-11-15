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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->date('report_date');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->json('tasks')->nullable(); // Array of completed tasks
            $table->json('work_in_progress')->nullable(); // Array of current work
            $table->json('issues')->nullable(); // Array of issues encountered
            $table->json('plans')->nullable(); // Array of plans for next period
            $table->timestamps();

            $table->unique(['user_id', 'report_date']); // One report per user per day
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
