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
        Schema::create('trs_orders_item', function (Blueprint $table) {
            $table->id('trordr_it_id');
            $table->unsignedBigInteger('fk_trordr_id');
            $table->unsignedBigInteger('fk_pdrk_id');
            $table->integer('ordr_it_quantity');
            $table->decimal('ordr_it_price', 10, 2);
            $table->decimal('ordr_it_subtotal', 12, 2);
            $table->enum('isactive', [0, 1])->default(1); //1=active,0=not active
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->string('user_create')->nullable();
            $table->string('user_update')->nullable();

            $table->foreign('fk_trordr_id')->references('trordr_id')->on('trs_orders');
            $table->foreign('fk_pdrk_id')->references('pdrk_id')->on('mst_produk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trs_orders_item');
    }
};