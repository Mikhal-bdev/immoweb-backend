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
        Schema::create('biens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('typebien_id')->constrained('typebiens')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('designation');
            $table->integer('nbrchambr');
            $table->decimal('long', 10, 2);
            $table->decimal('larg', 10, 2);
            $table->string('etat');
            $table->string('localisation');
            $table->text('map');
            $table->text('desc');
            $table->text('conditions');
            $table->decimal('loyer', 10, 2);
            $table->decimal('avance', 10, 2);
            $table->decimal('caution', 10, 2);
            $table->string('compteau');
            $table->string('comptelec');
            $table->string('locatorsell');
            $table->string('photo1')->nullable();
            $table->string('photo2')->nullable();
            $table->string('photo3')->nullable();
            $table->string('photo4')->nullable();
            $table->string('photo5')->nullable();
            $table->string('photo6')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biens');
    }
};
