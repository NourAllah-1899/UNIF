<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->enum('type', ['income', 'expense']);
            $table->string('name');
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['completed', 'pending', 'failed']);
            
            // Correct foreign key to categories
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            
            $table->string('subcategory')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};