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
        Schema::create('account_finances', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->bigInteger('account_number')->nullable();
            $table->enum('account_type',['Bank', 'Cash']);
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_finances');
    }
};
