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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_group_id')->constrained()->cascadeOnDelete();
            $table->foreignId('added_by')->constrained('users')->cascadeOnDelete();
            $table->string('name');
            $table->string('relationship_type');
            $table->date('birthday');
            $table->json('interest_tags')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
