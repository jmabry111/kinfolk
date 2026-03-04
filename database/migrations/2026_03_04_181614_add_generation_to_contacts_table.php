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
    Schema::table('contacts', function (Blueprint $table) {
        $table->boolean('birth_year_unknown')->default(false)->after('birthday');
        $table->enum('generation', [
            'Gen Z',
            'Millennial',
            'Gen X',
            'Baby Boomer',
            'Silent Generation',
        ])->nullable()->after('birth_year_unknown');
    });
}

public function down(): void
{
    Schema::table('contacts', function (Blueprint $table) {
        $table->dropColumn(['birth_year_unknown', 'generation']);
    });
}
};
