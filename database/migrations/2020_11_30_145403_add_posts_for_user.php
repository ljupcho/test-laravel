<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPostsForUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer( 'user_id' )->unsigned()->index();
            $table->string( 'title', 80 );
            $table->text( 'content' );
            $table->foreign( 'user_id' )->references( 'id' )->on( 'users' );
            $table->timestamps();
            $table->softDeletes();
            $table->index(['deleted_at']);
        });        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
