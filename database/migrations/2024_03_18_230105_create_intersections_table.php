<?php

use App\Models\Intersection;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntersectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Intersection::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->string('referring_domain')->nullable();
            $table->integer('rank')->default(0);
            $table->integer('backlinks')->default(0);
            $table->integer('domain_id')->index();
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
        Schema::dropIfExists(Intersection::getTableName());
    }
}
