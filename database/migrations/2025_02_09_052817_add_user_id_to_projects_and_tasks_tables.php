<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     *  Run the migrations.
     */
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            if (!Schema::hasColumn('projects', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable(false)->change();
            }
        });
    }

    /**
     *  Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->change(); 
        });

        // Schema::table('projects', function (Blueprint $table) {
        //     $table->dropForeign(['user_id']);
        //     $table->dropColumn('user_id');
        // });
    }
};
