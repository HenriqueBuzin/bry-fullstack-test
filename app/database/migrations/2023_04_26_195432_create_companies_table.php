<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('cnpj')->unique();
            $table->string('address')->required();
            $table->timestamps();
        });

        // Remove accents from the name field
        DB::statement('ALTER TABLE companies MODIFY name VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci');
    
        Schema::table('employees', function (Blueprint $table) {
            $table->foreign('company_id')->references('id')->on('companies');
        });
    }

    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
        });

        Schema::dropIfExists('companies');
    }
};
