<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('name', 100)->notNull(); // User name
            $table->string('email', 100)->unique()->notNull(); // Unique email address
            $table->string('password', 255)->notNull(); // Password
            $table->timestamps(); // Created and updated timestamps
        });

    }

    public function down()
    {
        Schema::dropIfExists('users');
    }

};
