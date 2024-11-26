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
        Schema::create('privileges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idtypeuser')->constrained('typeusers')->onDelete('cascade');
            $table->enum('typepriv', ['see', 'edit', 'del', 'add', 'admin', 'bloc', 'ban', 'restrict']);
            $table->string('designpriv');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('privileges');
    }
};
