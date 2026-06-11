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
        Schema::create('factures', function (Blueprint $table) {
            $table->id();
            $table->string('code')->uniqid();
            $table->string('pa')->uniqid()->nullable();
            $table->decimal('amount', 15, 2)->default(0);
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->integer('precedent')->default(0);
            $table->integer('actuel')->default(0);
            $table->integer('kwh_calcule')->default(0);
            $table->integer('rabais')->default(0);
            $table->integer('kwh_facture')->default(0);
            $table->integer('code_tarif')->default(0);
            $table->integer('interpretation')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factures');
    }
};
