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
    Schema::table('addresses', function (Blueprint $table) {
        $table->string('label')->nullable()->after('user_id');
        $table->boolean('is_default')->default(false)->after('complemento');
    });
}

public function down(): void
{
    Schema::table('addresses', function (Blueprint $table) {
        $table->dropColumn(['label', 'is_default']);
    });
}
};
