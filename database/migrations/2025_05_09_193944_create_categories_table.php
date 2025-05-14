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
        Schema::create('categories', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('type')->comment('income or expense'); // Or use enum if preferred
    $table->string('color')->nullable()->default('#cccccc'); // Optional for UI
    $table->string('icon')->nullable(); // Optional for UI
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->timestamps();
    $table->softDeletes();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
