<?php

use App\Enums\ProductStatus;
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
            $table->text('brand')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('currency_id')->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->decimal('price', 8, 2, true);
            $table->unsignedInteger('quantity')->default(0);
            $table->json('attachments')->nullable();
            $table->unsignedSmallInteger('status')->default(ProductStatus::Drafted)->comment('Refer ProductStatus enum.');
            $table->dateTime('posted_at')->nullable();
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
