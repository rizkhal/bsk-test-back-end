<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (! Schema::hasTable('categories')) {
            Schema::create('categories', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->tinyText('description')->nullable();
                $table->commonFields();
            });
        }
        
        if (!Schema::hasTable('posts')) {
            Schema::create('posts', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('slug')->unique();
                $table->tinyText('summary');
                $table->string('thumbnail')->nullable();
                $table->longText('content')->nullable();
                $table->foreignId('category_id')->constrained('categories', 'id')->onDelete('cascade');
                $table->commonFields();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('categories');
        Schema::dropIfExists('posts');
    }
};
