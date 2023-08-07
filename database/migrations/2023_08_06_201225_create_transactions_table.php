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
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id');
            $table->unsignedInteger('user_id')->index();
            $table->string('order_id')->index();
            $table->decimal('amount_paid', 20, 2)->index();
            $table->tinyInteger('status')->default(\App\Support\Enums\TransactionStatusEnum::PENDING->value)->index();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
