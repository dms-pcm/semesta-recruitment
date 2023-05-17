<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('name_user');
            $table->string('recruitment_id');
            $table->string('recruitment_name');
            $table->string('phone');
            $table->text('address');
            $table->string('email');
            // $table->string('tb')->nullable();
            // $table->string('bb')->nullable();
            $table->enum('status_berkas',['1', '2', '3'])->nullable();
            $table->enum('status_peserta',['1', '2'])->nullable();
            $table->text('alasan_berkasTidakLengkap')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('participants');
    }
}
