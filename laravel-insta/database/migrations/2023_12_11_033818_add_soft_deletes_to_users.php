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
        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
            // Soft Delete -> Soft deleting does not remove the model from the database; instead it will add a timestamp value to the 'deleted_at' column
            // Softdelete -> not removed the data but markd as 'deleted' by adding timestamps
            // Permanently delete -> delete without retrevial of data
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
