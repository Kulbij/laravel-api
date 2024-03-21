<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Domain;

class CreateDomainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Domain::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->string('target_domain')->nullable();
            $table->string('referring_domain')->nullable();
            $table->json('excluded_target')->nullable();
            $table->integer('rank')->default(0);
            $table->integer('backlinks')->default(0);
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
        Schema::dropIfExists(Domain::getTableName());
    }
}
