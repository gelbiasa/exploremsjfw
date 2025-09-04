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
        Schema::create('trs_bom_d', function (Blueprint $table) {
            $table->id('trs_bom_d_id');
            $table->unsignedBigInteger('fk_trs_bom_h_id');
            $table->string('header_desc', 150)->nullable();
            $table->string('plant', 20)->nullable();
            $table->string('usage', 20)->nullable();
            $table->string('alt_bom_no', 20)->nullable();
            $table->date('valid_from')->nullable();
            $table->string('alternative_bom_text', 100)->nullable();
            $table->decimal('product_qty', 12, 3)->nullable();
            $table->string('base_uom_header', 20)->nullable();
            $table->string('item_number', 20)->nullable();
            $table->string('type', 5)->nullable();
            $table->string('comp_material_code', 50)->nullable();
            $table->string('comp_desc', 150)->nullable();
            $table->decimal('comp_qty', 12, 3)->nullable();
            $table->string('uom', 20)->nullable();
            $table->string('wip_material', 50)->nullable();
            $table->decimal('length_per_unit', 12, 3)->nullable();
            $table->decimal('waste_jumbo', 12, 3)->nullable();
            $table->string('remark', 50)->nullable();
            $table->decimal('gsm', 10, 2)->nullable();
            $table->decimal('extra_panjang', 10, 2)->nullable();
            $table->decimal('jumbo', 10, 2)->nullable();
            $table->decimal('rewind', 10, 2)->nullable();
            $table->decimal('berat_sfg', 12, 3)->nullable();
            $table->decimal('lebar', 12, 3)->nullable();
            $table->enum('isactive', [0, 1])->default(1);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->string('user_create')->nullable();
            $table->string('user_update')->nullable();
            $table->foreign('fk_trs_bom_h_id', 'fk_bom')
                  ->references('trs_bom_h_id')
                  ->on('trs_bom_h')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trs_bom_d');
    }
};
