<?php

declare(strict_types=1);

use App\Enums\Gender;
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
        Schema::create('member_profiles', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict');
            $table->string('member_number')->unique();
            $table->string('nik')->unique();
            $table->string('avatar')->nullable();
            $table->string('gender')->default(Gender::Male->value);
            $table->string('birth_place');
            $table->date('birth_date');
            $table->text('address');
            $table->foreignId('province_id')->constrained('provinces')->onDelete('restrict');
            $table->foreignId('city_id')->constrained('cities')->onDelete('restrict');
            $table->foreignId('district_id')->constrained('districts')->onDelete('restrict');
            $table->foreignId('village_id')->constrained('villages')->onDelete('restrict');
            $table->string('occupation');
            $table->date('register_date');
            $table->foreignId('created_by')->constrained('users')->onDelete('restrict');
            $table->timestamps();
            $table->softDeletes();

            $table->index('member_number');
            $table->index('nik');
            $table->index('created_by');
            $table->index('province_id');
            $table->index('city_id');
            $table->index('district_id');
            $table->index('village_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_profiles');
    }
};
