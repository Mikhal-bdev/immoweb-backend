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
        Schema::create('agences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nom');
            $table->string('photagen');
            $table->string('regcomm');
            $table->string('docrccm');
            $table->string('ifu');
            $table->string('docifu');
            $table->string('numcni');
            $table->string('doccni');
            $table->string('cip');
            $table->string('doccip');
            $table->string('adresse');
            $table->string('mail');
            $table->string('contact');
            $table->string('whatsapp');
            $table->text('descrip');
            $table->enum('certification', ['Approuvé', 'Non']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agences');
    }
};
