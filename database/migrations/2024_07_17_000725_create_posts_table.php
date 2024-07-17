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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string( 'name' )->nulable( false )->default( '' );
            $table->string( 'slug' )->nulable( false )->default( '' )->unique();
            $table->text( 'extract' )->nulable( false );
            $table->longText( 'body' )->nulable( false );
            $table->char( 'status', '1' )->nulable( false )->default( '1' );

            $table->foreignId( 'category_id' )->constrained()->cascadeOnDelete();
            $table->foreignId( 'user_id' )->constrained()->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
