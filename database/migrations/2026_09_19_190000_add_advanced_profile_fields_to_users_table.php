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
        Schema::table('users', function (Blueprint $table) {
            $table->string('headline')->nullable()->after('phone_number');
            $table->text('bio')->nullable()->after('headline');
            $table->string('location')->nullable()->after('bio');
            $table->string('province')->nullable()->after('location');
            $table->string('city')->nullable()->after('province');
            $table->string('avatar_path')->nullable()->after('city');
            $table->string('banner_path')->nullable()->after('avatar_path');
            $table->string('cv_path')->nullable()->after('banner_path');
            $table->string('cv_name')->nullable()->after('cv_path');
        });

        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('receiver_id')->constrained('users')->cascadeOnDelete();
            $table->text('body');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'headline',
                'bio',
                'location',
                'province',
                'city',
                'avatar_path',
                'banner_path',
                'cv_path',
                'cv_name',
            ]);
        });

        Schema::dropIfExists('messages');
    }
};
