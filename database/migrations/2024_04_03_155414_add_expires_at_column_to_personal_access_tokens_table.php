<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExpiresAtColumnToPersonalAccessTokensTable extends Migration
{
    public function up()
    {
        Schema::table('personal_access_tokens', function (Blueprint $table) {
            // Add the expires_at column as nullable timestamp
            $table->timestamp('expires_at')->nullable();
        });
    }

    public function down()
    {
        Schema::table('personal_access_tokens', function (Blueprint $table) {
            // Remove the expires_at column if the migration is rolled back
            $table->dropColumn('expires_at');
        });
    }
}
