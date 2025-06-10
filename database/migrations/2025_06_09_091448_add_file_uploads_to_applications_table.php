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
        Schema::table('applications', function (Blueprint $table) {
            $table->string('resume')->nullable();
            $table->string('cover_letter')->nullable();
            $table->string('resume_original_name')->nullable();
            $table->string('cover_letter_original_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn('resume');
            $table->dropColumn('cover_letter');
            $table->dropColumn('resume_original_name');
            $table->dropColumn('cover_letter_original_name');
        });
    }
};
