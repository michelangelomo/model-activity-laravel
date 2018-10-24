<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModelActivitiesTable extends Migration
{
    /**
     * Run the Database.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('model_activities', function (Blueprint $table) {
            $table->increments('id');

            $table->morphs('model');
            $table->unsignedInteger('transaction_type');

            $table->longText('differences');

            $table->longText('extra')->nullable();

            if(Schema::hasTable('users')) {
                $table->unsignedInteger('user_id')->nullable();
                $table->foreign('user_id')->references('id')->on('users');
            }

            $table->timestamps();
        });
    }

    /**
     * Reverse the Database.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('model_activities');
    }
}
