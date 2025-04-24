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
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('nazwa');
            $table->string('value');
            $table->timestamps();
        });

         DB::table('site_settings')->insert([
            'nazwa' => 'nazwa jakiegoś tam sobie globalnego ustawienia xdd',
            'value' => 'PIWO',
            'created_at'=> NOW(),
            'updated_at'=> NOW(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
