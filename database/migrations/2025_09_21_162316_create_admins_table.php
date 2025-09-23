<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();

            // Nếu bạn dùng SoftDeletes trong model
            $table->softDeletes();

            // Tuỳ chọn nếu bạn có 2FA
            $table->string('google2fa_secret')->nullable();
            $table->boolean('two_factor_enabled')->default(false);
            $table->timestamp('google2fa_ts')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
