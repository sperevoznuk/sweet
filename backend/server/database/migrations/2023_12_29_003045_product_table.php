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
        //

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Имя');
            $table->integer('price')->comment('Цена');
            $table->integer('weight')->comment('Вес, г.');
            $table->string('size')->comment('Размер');
            $table->string('image')->comment('Изображение');
            $table->integer('status')->comment('Статус');
            $table->timestamps();
        });






        Schema::create('partials', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Имя');
            $table->string('image')->comment('Изображение');
            $table->float('cost')->comment('Себестоимость');
            $table->timestamps();
        });



        Schema::create('product_partials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained();
            $table->foreignId('partial_id')->constrained();
            $table->integer('quantity')->comment('Кол-во');
        });

        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Имя');
            $table->integer('sort')->comment('Сортировка');
        });

        Schema::create('ingrs', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Имя');
            $table->foreignId('unit_id')->constrained();
            $table->float('value')->comment('Значение');
            $table->integer('cost')->comment('Себестоимость');
        });


        Schema::create('partial_ingrs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partial_id')->constrained();
            $table->foreignId('ingr_id')->constrained();
            $table->float('quantity')->comment('Кол-во');
        });

        // order

        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Имя');
            $table->string('first_name')->comment('Фамилия');
            $table->string('last_name')->comment('Отчество');
            $table->string('phone')->comment('Телефон');
            $table->string('email')->comment('Почта');
            $table->string('comment')->comment('Комментарий');
            $table->integer('status')->comment('Статус');

            $table->string('vk');
            $table->string('tg');
            $table->string('instagram');
        });
        Schema::create('order_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Имя');
            $table->text('descr')->comment('Описание');
        });
        Schema::create('shipings', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Имя');
            $table->text('description')->comment('Описание');
            $table->integer('price')->comment('Стоимость по умолчанию');
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained();
            $table->foreignId('status_id')->constrained('order_statuses');

            $table->integer('total');
            $table->integer('prepayment');
            $table->integer('discount');

            $table->foreignId('shiping_id')->constrained();
            $table->dateTime('shiping_date')->comment('Дата доставки');
            $table->integer('shiping_price')->comment('Стоиомсть доставки');

            $table->string('comment');

            $table->timestamps();
        });

        Schema::create('order_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained();

            $table->string('name')->comment('Имя');
            $table->integer('price')->comment('Стоимость');
            $table->integer('quantity');
            $table->float('cost');
            $table->integer('product_id');
        });

        Schema::create('order_product_partials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_products_id')->constrained();

            $table->string('name')->comment('Имя');
            $table->integer('quantity');
            $table->float('cost');
            $table->integer('partial_id');
        });

        Schema::create('order_product_partial_ingrs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_product_partials_id')->constrained();

            $table->string('name')->comment('Имя');
            $table->float('quantity');
            $table->float('cost');
            $table->foreignId('unit_id')->constrained();
            $table->integer('ingr_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::dropIfExists('order_product_partial_ingrs');
        Schema::dropIfExists('order_product_partials');
        Schema::dropIfExists('order_products');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('order_statuses');

        Schema::dropIfExists('product_partials');
        Schema::dropIfExists('products');

        Schema::dropIfExists('partial_ingrs');
        Schema::dropIfExists('partials');

        Schema::dropIfExists('ingrs');
        Schema::dropIfExists('units');
        Schema::dropIfExists('shipings');
        Schema::dropIfExists('customers');
    }
};
