<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('element_structures', function (Blueprint $table) {
            $table->id();
            $table->string('dev_name')->default(null);
            $table->string('view_name')->default(null);
            $table->integer('parentId')->nullable(true)->default(null);
            $table->string('type')->default(null);
            $table->integer('order')->default(null);
            $table->json('CustomStyleOptions')->nullable(true)->default(null);
            $table->timestamps();
        });

        DB::table('element_structures')->insert([
            'dev_name' => 'Container_Default',
            'view_name' => 'home',
            'type' => 'container',
            'order' => 1,
            'created_at'=> NOW(),
            'updated_at'=> NOW(),
        ]);

        DB::table('element_structures')->insert([
            'dev_name' => 'Text_colum_3',
            'view_name' => 'home',
            'parentId' => 1,
            'type' => 'text',
            'order' => 1,
            'created_at'=> NOW(),
            'updated_at'=> NOW(),
        ]);
        DB::table('element_structures')->insert([
            'dev_name' => 'Container_Default',
            'view_name' => 'home',
            'type' => 'container',
            'parentId' => 1,
            'order' => 2,
            'created_at'=> NOW(),
            'updated_at'=> NOW(),
        ]);
        DB::table('element_structures')->insert([
            'dev_name' => 'Text_colum_3',
            'view_name' => 'home',
            'parentId' => 3,
            'type' => 'text',
            'order' => 2,
            'created_at'=> NOW(),
            'updated_at'=> NOW(),
        ]);
        DB::table('element_structures')->insert([
            'dev_name' => 'Text_colum_3',
            'view_name' => 'home',
            'parentId' => 3,
            'type' => 'text',
            'order' => 1,
            'created_at'=> NOW(),
            'updated_at'=> NOW(),
        ]);
        DB::table('element_structures')->insert([
            'dev_name' => 'Text_colum_3',
            'view_name' => 'home',
            'parentId' => 1,
            'type' => 'text',
            'order' => 3,
            'created_at'=> NOW(),
            'updated_at'=> NOW(),
        ]);
        DB::table('element_structures')->insert([
            'dev_name' => 'Image_200x200',
            'view_name' => 'home',
            'parentId' => 1,
            'type' => 'media',
            'order' => 4,
            'created_at'=> NOW(),
            'updated_at'=> NOW(),
        ]);

        
        DB::table('element_structures')->insert([
            'dev_name' => 'Container_Default',
            'view_name' => 'home',
            'type' => 'container',
            'order' => 2,
            'created_at'=> NOW(),
            'updated_at'=> NOW(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('element_structures');
    }
};