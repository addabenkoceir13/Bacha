<?php

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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->string('name_product');
            $table->string('quantity');
            $table->string('amount');
            $table->enum('is_debt',[0,1])->default(0);
            $table->string('name_client')->nullable();
            $table->text('notes')->nullable();
            $table->date('date_debt');
            $table->enum('type',['debt', 'normal'])->default('normal');
            $table->enum('status_debt',['paid', 'unpaid'])->default('unpaid');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
};
