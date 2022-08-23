<?php

use App\Enums\ProductPostStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_category_id')->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->foreignId('currency_id')->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->decimal('price', 8, 2, true);
            $table->unsignedSmallInteger('status')->default(ProductPostStatus::Pending)->comment('Refer ProductPostStatus enum.');
            $table->dateTime('posted_at')->nullable();
            $table->string('platform', 28)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
