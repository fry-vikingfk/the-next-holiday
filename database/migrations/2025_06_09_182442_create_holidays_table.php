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
        if (! Schema::hasTable('holidays')) {
            Schema::create('holidays', function (Blueprint $table) {
                $table->id();
                $table->date('date');
                $table->string('name');
                $table->text('note')->nullable(); // "hinweis" field
                $table->boolean('is_statutory')->default(false);  // gesetzlich
                $table->unsignedSmallInteger('year');
                $table->timestamps();
            });

            // Add a unique index for the combination of date and year
            Schema::table('holidays', function (Blueprint $table) {
                $table->unique(['date', 'year'], 'unique_date_year');
            });
            // Add a foreign key constraint to the states table
            Schema::table('holidays', function (Blueprint $table) {
                $table->foreignId('state_id')->nullable()->constrained('states')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('holidays');
    }
};
