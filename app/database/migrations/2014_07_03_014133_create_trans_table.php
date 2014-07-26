<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('trans', function(Blueprint $table)
		{
			$table->bigIncrements('ID');
			$table->bigInteger('AccountID');
			$table->string('Name', 128);
			$table->decimal('Amount', 10, 2);
			$table->string('Method', 32); // cash, check, creditcard, transfer, other
			$table->dateTime('PaymentDate');
			$table->string('Note', 255)->nullable();

			$table->index('AccountID');
			//$table->foreign('AccountID')->references('ID')->on('accounts');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('trans');
	}

}
