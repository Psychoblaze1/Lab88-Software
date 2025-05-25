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
        Schema::create('limit_parameters', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('limit_suite_id')->constrained();
            $table->foreignUuid('test_parameter_id')->constrained();
            $table->string('min')->nullable();
            $table->string('max')->nullable();
            $table->string('comparator')->nullable();
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
        Schema::dropIfExists('limit_parameters');
    }
};
