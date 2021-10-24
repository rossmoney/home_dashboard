<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpendsTable extends Migration
{
    public function up()
    {
        Schema::create('spends', function (Blueprint $table) {
            $table->id();
            $table->string('desc');
            $table->date('date');
            $table->integer('category_id');
            $table->integer('user_id');
            $table->decimal('cost', 8, 2);
            $table->timestamps();
        });
    }
}
