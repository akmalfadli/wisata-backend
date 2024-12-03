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
        Schema::create('credits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('name');
            $table->bigInteger('nominal');
            $table->text('description');
            $table->date('credit_date');
            $table->unsignedBigInteger('account_finance_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');

            $table->foreign('category_id')
                ->references('id')->on('finance_categories');
            $table->foreign('account_finance_id')
                ->references('id')->on('account_finances');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credits');
    }
};
