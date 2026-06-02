<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pieces_conviction', function (Blueprint $table) {
            $table->softDeletes(); // أضف عمود deleted_at
        });
    }

    public function down()
    {
        Schema::table('pieces_conviction', function (Blueprint $table) {
            $table->dropSoftDeletes(); // حذف العمود عند التراجع
        });
    }
};