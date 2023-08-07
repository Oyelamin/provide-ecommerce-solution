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
        Schema::create('items', function (Blueprint $table) {
            $table->uuid('id');
            $table->unsignedInteger('admin_id'); // Admin || Creator
            $table->string('title')->index();
            $table->longText('description')->nullable()->default(null);
            $table->decimal('price', 20, 2)->default(0.00)->index();
            $table->string('currency')->default(\App\Support\Enums\CurrencyEnum::DOLLAR->value);
            $table->tinyInteger('status')->default(\App\Support\Enums\ItemStatusEnum::ACTIVE->value)->index();
            $table->integer('total_stocked')->default(0)->index();
            $table->integer('available_stock')->default(0)->index();
            $table->dateTime('last_stocked')->nullable()->default(null)->index();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
