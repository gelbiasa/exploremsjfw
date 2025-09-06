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
        Schema::create('mst_material', function (Blueprint $table) {
            $table->bigIncrements('id'); // bigint(20) UNSIGNED AUTO_INCREMENT
            $table->string('kode_baru_fg', 29);
            $table->string('id_mat_group', 3); // dinaikkan dari 2 ke 3 (RM, MB, PK, RC, FG, SFG)
            $table->string('customer', 20);
            $table->string('product_name', 100); // dinaikkan dari 25 ke 100 untuk menghindari error panjang teks
            $table->enum('division', ['10', '20']);
            $table->string('mat_g1', 2);
            $table->string('mat_g2', 3);
            $table->string('mat_g3', 3);
            $table->string('keterangan', 255)->nullable();
            $table->double('length', 10, 3)->nullable();
            $table->decimal('width', 10, 3)->nullable();
            $table->decimal('weight', 10, 2)->nullable();
            $table->string('alt_uom', 3);
            $table->integer('top_load')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->string('user_create', 255)->nullable();
            $table->string('user_update', 255)->nullable();
            $table->string('it_update', 255)->nullable();
            $table->enum('status', ['0', '1', '2'])->default('0');
            $table->enum('isactive', ['0', '1'])->default('1');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mst_material');
    }
};
