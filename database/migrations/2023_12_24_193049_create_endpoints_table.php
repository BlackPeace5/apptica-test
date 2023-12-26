<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEndpointsTable extends Migration
{
    protected $connection = "pgsql";

    public function up()
    {
        Schema::create('endpoints', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('application_id');
            $table->bigInteger('country_id');
            $table->jsonb('data')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('endpoints');
    }
}
