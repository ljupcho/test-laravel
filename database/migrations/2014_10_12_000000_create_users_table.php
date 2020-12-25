<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string( 'first_name', 80 );
            $table->string( 'last_name', 80 );
            $table->string( 'email', 255 )->unique();
            $table->integer('age')->nullable();
            $table->integer('group_id')->unsigned()->index();
            $table->foreign( 'group_id' )->references( 'id' )->on( 'groups' );
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
        // Schema::dropIfExists('users');
    }
}
