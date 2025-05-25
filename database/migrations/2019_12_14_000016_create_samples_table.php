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
        Schema::create('samples', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('account_id')->nullable();
            $table->foreignUuid('limit_suite_id')->nullable();
            $table->foreignUuid('lab_id')->nullable();
            $table->foreignUuid('asset_chain_id')->nullable();
            $table->string('name');
            $table->unsignedInteger('status')->default(0);
            $table->boolean('pass')->nullable();
            $table->string('type')->nullable();
            $table->text('conformity')->nullable();
            // THIS CAN BECOME ITS OWN MODEL
            $table->string('drawn_by')->nullable();
            $table->dateTime('drawn_at')->nullable();
            $table->string('received_by')->nullable();
            $table->dateTime('received_at')->nullable();
            $table->string('tested_by')->nullable();
            $table->dateTime('tested_at')->nullable();
            $table->string('released_by')->nullable();
            $table->dateTime('released_at')->nullable();
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
        Schema::dropIfExists('samples');
    }
};
