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
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id');
            $table->unsignedInteger('user_id')->index();
            $table->string('address');
            $table->string('contact');
            $table->integer('quantity')->default(0)->index();
            $table->decimal('total_amount', 20, 2)->default(0.00)->index();
            $table->tinyInteger('status')->default(\App\Support\Enums\OrderStatusEnum::PENDING->value)->index();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
