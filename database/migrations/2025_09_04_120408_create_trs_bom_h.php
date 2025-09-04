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
        Schema::create('trs_bom_h', function (Blueprint $table) {
            $table->id('trs_bom_h_id'); // Auto increment primary key
            $table->string('mat_type', 20)->nullable();
            $table->string('resource', 50)->nullable();
            $table->decimal('capacity', 10, 2)->nullable();
            $table->decimal('width', 10, 2)->nullable();
            $table->decimal('length', 10, 2)->nullable();
            $table->string('product', 50)->nullable();
            $table->string('process', 50)->nullable();
            $table->string('material_fg_sfg_kode_lama', 100)->nullable();
            $table->string('material_fg_sfg', 150)->nullable();
            $table->enum('isactive', [0, 1])->default(1);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->string('user_create')->nullable();
            $table->string('user_update')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trs_bom_h');
    }
};