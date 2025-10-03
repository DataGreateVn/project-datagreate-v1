<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('translations', function (Blueprint $t) {
            $t->id();
            $t->string('locale', 10);                  // vi, en-US...
            $t->string('namespace', 50)->default('*'); // app, email, theme, '*'...
            $t->string('group', 100)->default('*');    // homepage, auth, validation...
            $t->string('key', 191);                    // hero.title
            $t->text('value')->nullable();             // nội dung bản dịch
            $t->unsignedBigInteger('updated_by')->nullable();
            $t->timestamps();

            // tra cứu nhanh + đảm bảo duy nhất
            $t->unique(['locale', 'namespace', 'group', 'key'], 'tr_unique');
            $t->index(['locale', 'group'], 'tr_idx_locale_group');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('translations');
    }
};
