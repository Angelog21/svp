<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Holiday;

class CreateHolidaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('holidays', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('applicant_id');
            $table->foreign('applicant_id')->references('id')->on('users');
            $table->unsignedBigInteger('supervisor_id')->nullable();
            $table->unsignedBigInteger('approver_id');
            $table->foreign('approver_id')->references('id')->on('users');
            $table->unsignedBigInteger('office_id');
            $table->foreign('office_id')->references('id')->on('offices');
            $table->integer('request_days');
            $table->integer('enjoyed_days');
            $table->integer('leftover_days');
            $table->date('start_date');
            $table->date('end_date');
            $table->date('refund_date');
            $table->string('observation')->nullable();
            $table->string('state')->default(Holiday::PROCESO);
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
        Schema::dropIfExists('holidays');
    }
}
