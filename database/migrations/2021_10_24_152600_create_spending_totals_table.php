<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpendingTotalsTable extends Migration
{
    public function up()
    {
        Schema::create('spending_totals', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->decimal('total', 8, 2);
            $table->timestamps();
        });
    }
}
