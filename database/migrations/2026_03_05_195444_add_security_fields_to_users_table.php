<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

public function up()
{
    Schema::table('users', function (Blueprint $table) {

        $table->integer('login_attempts')->default(0);
        $table->timestamp('lock_until')->nullable();
        $table->boolean('is_blocked')->default(false);

    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {

        $table->dropColumn('login_attempts');
        $table->dropColumn('lock_until');
        $table->dropColumn('is_blocked');

    });
}

};
