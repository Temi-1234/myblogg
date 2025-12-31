<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            // Add the new status column
            $table->string('status')->default('draft')->after('content');
        });

        // Convert existing is_published data to status
        DB::table('posts')->where('is_published', 1)->update(['status' => 'published']);
        DB::table('posts')->where('is_published', 0)->update(['status' => 'draft']);

        // Remove the old column
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('is_published');
        });
    }

    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            // Add back is_published column
            $table->boolean('is_published')->default(false)->after('content');
        });

        // Convert status back to is_published
        DB::table('posts')->where('status', 'published')->update(['is_published' => 1]);
        DB::table('posts')->where('status', '!=', 'published')->update(['is_published' => 0]);

        // Remove the status column
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};