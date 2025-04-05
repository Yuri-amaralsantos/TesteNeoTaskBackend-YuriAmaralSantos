<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() {
        Schema::table('musicas', function (Blueprint $table) {
            $table->enum('status', ['pendente', 'aprovado'])->default('pendente')->after('youtube_id');
        });
    }

    public function down() {
        Schema::table('musicas', function (Blueprint $table) {
            $table->dropColumn(['status']);
        });
    }
};
