<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBorrowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('borrows', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali');
            $table->string('jumlah_buku', 100);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('no action');
            $table->unsignedBigInteger('members_id')->nullable();
            $table->foreign('members_id')->references('id')->on('members')->onDelete('cascade')->onUpdate('no action');
            $table->unsignedBigInteger('books_id')->nullable();
            $table->foreign('books_id')->references('id')->on('books')->onDelete('cascade')->onUpdate('no action');
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
        Schema::dropIfExists('borrows');
    }
}
