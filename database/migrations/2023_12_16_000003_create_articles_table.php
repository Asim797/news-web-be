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
        Schema::create('articles', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->id();
            $table->foreignId('author_id')->nullable();
            $table->foreignId('source_id')->nullable();
            $table->foreignId('category_id')->nullable();
            $table->string('title', 255)->unique();
            $table->text('description')->nullable();
            $table->text('image')->nullable();
            $table->text('url')->nullable();
            $table->dateTime('published_at')->nullable();
            $table->timestamps();

            $table->foreign('author_id')
                ->references('id')->on('authors')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('source_id')
                ->references('id')->on('sources')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('category_id')
                ->references('id')->on('categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
