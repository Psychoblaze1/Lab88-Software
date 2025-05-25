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
        Schema::create('sample_results', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('sample_id')->constrained();
            $table->foreignUuid('test_parameter_id')->nullable();
            $table->decimal('min', 10, 4)->nullable();
            $table->decimal('max', 10, 4)->nullable();
            $table->string('comparator')->nullable();
            $table->string('value')->nullable();
            $table->boolean('pass')->nullable();
            $table->boolean('validated')->default(false);
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
        Schema::dropIfExists('sample_results');
    }
};
