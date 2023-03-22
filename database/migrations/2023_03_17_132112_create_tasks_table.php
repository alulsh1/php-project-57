<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("tasks", function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->text("description")->nullable();
            $table
                ->foreignId("created_by_id")
                ->nullable()
                ->index()
                ->constrained("users");
            $table
                ->foreignId("assigned_to_id")
                ->nullable()
                ->index()
                ->constrained("users");
            $table
                ->foreignId("status_id")
                ->index()
                ->constrained("task_statuses");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("tasks");
    }
};
