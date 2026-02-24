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
        Schema::create('gifts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('description');
            $table->decimal('budget', 8, 2)->nullable();
            $table->string('url')->nullable();
            $table->boolean('is_public')->default(true);
            $table->boolean('is_purchased')->default(false);
            $table->foreignId('purchased_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
  }  

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gifts');
    }
};
