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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->string('job_title');
            $table->string('company_name');
            $table->string('company_website');
            $table->date('applied_date');
            $table->enum('status', ['pending', 'interview', 'offer', 'rejected'])->default('pending');
            $table->text('job_description')->nullable();
            $table->string('salary_range')->nullable();
            $table->string('location')->nullable();
            $table->string('application_link')->nullable();
            $table->date('posted_date')->nullable();
            $table->date('application_deadline')->nullable();

            // add tags with onsite, remote, hybrid
            $table->enum('type', ['onsite', 'remote', 'hybrid', 'freelance'])->default('onsite');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
