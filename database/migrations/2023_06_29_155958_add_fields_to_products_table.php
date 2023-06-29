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
        Schema::table('products', function (Blueprint $table) {

            $table->integer('shop_id')->unsigned()->nullable();
            $table->integer('manufacturer_id')->unsigned()->nullable();
            $table->string('brand')->nullable();

            $table->string('model_number')->nullable();
            $table->string('mpn')->nullable();
            $table->string('gtin')->nullable();
            $table->string('gtin_type')->nullable();

            //Admin can set a MIN and MAX price for a product
            $table->decimal('min_price', 20, 6)->default(0)->nullable();
            $table->decimal('max_price', 20, 6)->nullable();
            $table->integer('origin_country')->unsigned()->nullable();
            $table->boolean('has_variant')->nullable();
            $table->boolean('requires_shipping')->default(1)->nullable();
            $table->boolean('downloadable')->nullable();
            $table->string('slug')->unique();
            $table->text('meta_title')->nullable();
            $table->longtext('meta_description')->nullable();
            $table->bigInteger('sale_count')->nullable();
            $table->boolean('active')->default(1);
            $table->softDeletes();

        });

        Schema::create('gtin_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->text('description');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            Schema::dropIfExists('gtin_types');
            Schema::dropIfExists('products');
        });
    }
};
