<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpendingCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('spending_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyInteger('recurrent');
        });
    }
}
