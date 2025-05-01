<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('element_values', function (Blueprint $table) {
            $table->id();
            $table->integer('parentId')->nullable(false);
            $table->string('order')->default(null);
            $table->json('CustomStyleOptions')->nullable(true)->default(null);
            $table->string('type')->default(null);
            $table->string('view_name')->default(null);
            $table->string('value')->default(null);
            $table->timestamps();
        });

        DB::table('element_values')->insert([
            'parentId' => 2,
            'view_name' => 'home',
            'order' => 1,
            'type' => 'text',
            'value' => 'banan',
            'created_at'=> NOW(),
            'updated_at'=> NOW(),
        ]);
        
        DB::table('element_values')->insert([
            'parentId' => 2,
            'view_name' => 'home',
            'order' => 2,
            'type' => 'text',
            'value' => 'jabłko',
            'created_at'=> NOW(),
            'updated_at'=> NOW(),
        ]);
        
        DB::table('element_values')->insert([
            'parentId' => 2,
            'view_name' => 'home',
            'order' => 3,
            'type' => 'text',
            'value' => 'kiwi',
            'created_at'=> NOW(),
            'updated_at'=> NOW(),
        ]);

        DB::table('element_values')->insert([
            'parentId' => 4,
            'view_name' => 'home',
            'order' => 1,
            'type' => 'text',
            'value' => 'auto',
            'created_at'=> NOW(),
            'updated_at'=> NOW(),
        ]);
        
        DB::table('element_values')->insert([
            'parentId' => 4,
            'view_name' => 'home',
            'order' => 2,
            'type' => 'text',
            'value' => 'łopata',
            'created_at'=> NOW(),
            'updated_at'=> NOW(),
        ]);
        
        DB::table('element_values')->insert([
            'parentId' => 4,
            'view_name' => 'home',
            'order' => 3,
            'type' => 'text',
            'value' => 'kobieta',
            'created_at'=> NOW(),
            'updated_at'=> NOW(),
        ]);

        DB::table('element_values')->insert([
            'parentId' => 5,
            'view_name' => 'home',
            'order' => 1,
            'type' => 'text',
            'value' => 'piwo',
            'created_at'=> NOW(),
            'updated_at'=> NOW(),
        ]);
        
        DB::table('element_values')->insert([
            'parentId' => 5,
            'view_name' => 'home',
            'order' => 2,
            'type' => 'text',
            'value' => 'wino',
            'created_at'=> NOW(),
            'updated_at'=> NOW(),
        ]);
        
        DB::table('element_values')->insert([
            'parentId' => 5,
            'view_name' => 'home',
            'order' => 3,
            'type' => 'text',
            'value' => 'denaturat',
            'created_at'=> NOW(),
            'updated_at'=> NOW(),
        ]);

        DB::table('element_values')->insert([
            'parentId' => 6,
            'view_name' => 'home',
            'order' => 1,
            'type' => 'text',
            'value' => 'troche',
            'created_at'=> NOW(),
            'updated_at'=> NOW(),
        ]);
        
        DB::table('element_values')->insert([
            'parentId' => 6,
            'view_name' => 'home',
            'order' => 2,
            'type' => 'text',
            'value' => 'tego',
            'created_at'=> NOW(),
            'updated_at'=> NOW(),
        ]);
        
        DB::table('element_values')->insert([
            'parentId' => 6,
            'view_name' => 'home',
            'order' => 3,
            'type' => 'text',
            'value' => 'dużo',
            'created_at'=> NOW(),
            'updated_at'=> NOW(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('element_values');
    }
};
