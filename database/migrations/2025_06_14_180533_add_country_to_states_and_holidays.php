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
        if (!Schema::hasTable('countries')) {
            Schema::create('countries', function (Blueprint $table) {
                $table->id();
                $table->string('code', 2)->unique(); // ISO 3166-1 alpha-2
                $table->string('name');
                $table->timestamps();
            });
        }

        if (!Schema::hasColumn('states', 'country_id')) {
            Schema::table('states', function (Blueprint $table) {
                $table->foreignId('country_id')
                    ->nullable()
                    ->after('name')
                    ->constrained('countries')
                    ->onDelete('set null');
            });
        }

        if (!Schema::hasColumn('holidays', 'country_id')) {
            Schema::table('holidays', function (Blueprint $table) {
                $table->foreignId('country_id')
                    ->nullable()
                    ->after('note')
                    ->constrained('countries')
                    ->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('holidays', function (Blueprint $table) {
            $table->dropForeign(['country_id']);
            $table->dropColumn('country_id');
        });

        Schema::table('states', function (Blueprint $table) {
            $table->dropForeign(['country_id']);
            $table->dropColumn('country_id');
        });

        Schema::dropIfExists('countries');
    }
};
