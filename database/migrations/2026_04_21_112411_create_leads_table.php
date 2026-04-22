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
            $table->string('phone');
            $table->enum('status', ['open', 'in_progress', 'closed', 'rejected'])->default('open');
            $table->timestamps();
            $table->boolean('is_deleted')->default(0);
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
