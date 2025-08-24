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
        Schema::create('mst_employee', function (Blueprint $table) {
            $table->id('empl_id');
            $table->string('empl_username', 20);
            $table->string('empl_firstname', 255);
            $table->string('empl_lastname', 255);
            $table->string('empl_email', 255);
            $table->string('empl_idroles', 6)->nullable();
            $table->string('empl_password', 255);
            $table->string('empl_image', 255)->default('noimage.png');
            $table->enum('isactive', [0, 1])->default(1); //1=active,0=not active
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
        Schema::dropIfExists('mst_employee');
    }
};
