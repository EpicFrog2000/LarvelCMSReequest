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
        Schema::create('element_structures', function (Blueprint $table) {
            $table->id();
            $table->string('dev_name')->default(null);
            $table->string('view_name')->default(null);
            $table->integer('parentId')->nullable(true)->default(null);
            $table->string('type')->default(null);
            $table->json('values')->nullable(true)->default(null);
            $table->integer('order')->default(null);
            $table->json('CustomStyleOptions')->nullable(true)->default(null);
            $table->timestamps();
        });

        // Przykłądowe elementy i kontener
        DB::table('element_structures')->insert([
            'dev_name' => 'container_1',
            'view_name' => 'home',
            'type' => 'container',
            'order' => 1,
            'created_at'=> NOW(),
            'updated_at'=> NOW(),
            ]);

        DB::table('element_structures')->insert([
            'dev_name' => 'testowy',
            'view_name' => 'home',
            'parentId' => 1,
            'type' => 'text',
            'values' => json_encode(['banan', 'jabłko', 'płaszcz chroniący przeciw wyładowniom elektrostatycznym']),
            'order' => 1,
            'created_at'=> NOW(),
            'updated_at'=> NOW(),
        ]);
        DB::table('element_structures')->insert([
            'dev_name' => 'testowy',
            'view_name' => 'home',
            'parentId' => 2,
            'type' => 'text',
            'values' => json_encode(['gunwo', 'pizda', 'qwerqwer']),
            'order' => 1,
            'created_at'=> NOW(),
            'updated_at'=> NOW(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('element_structures');
    }
};