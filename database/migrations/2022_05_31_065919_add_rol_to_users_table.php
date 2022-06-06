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
        Schema::table('users', function (Blueprint $table) {
            $table->integer('rol');
            $table->string('apellidos');
            $table->string('numero_identificacion');
            $table->text('direccion');
            $table->foreignId('ciudad_id')->constrained('ciudades');
            $table->foreignId('sucursal_id')->constrained('sucursales');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('rol');
            $table->dropColumn('apellidos');
            $table->dropColumn('numero_identificacion');
            $table->dropColumn('direccion');
            $table->dropColumn('ciudad_id');
            $table->dropColumn('sucursal_id');
        });
    }
};
