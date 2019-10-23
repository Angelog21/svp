<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Permit;

class CreatePermitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('applicant_id');
            $table->foreign('applicant_id')->references('id')->on('users');
            $table->unsignedBigInteger('supervisor_id');
            $table->foreign('supervisor_id')->references('id')->on('users');
            $table->unsignedBigInteger('office_id');
            $table->foreign('office_id')->references('id')->on('offices');
            $table->date('start_date');
            $table->date('end_date');
            $table->date('refund_date');
            $table->integer('days');
            $table->unsignedBigInteger('reason_id');
            $table->foreign('reason_id')->references('id')->on('reasons');
            $table->char('turn',1)->nullable();
            $table->boolean('remunerate');
            $table->boolean('substitute_require');
            $table->text('description')->nullable();
            $table->string('observation')->nullable();
            $table->string('state',20)->default(Permit::PROCESO);
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
        Schema::dropIfExists('permits');
    }
}
