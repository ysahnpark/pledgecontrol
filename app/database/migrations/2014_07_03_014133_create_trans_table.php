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
			$table->dateTime('PaymentDate');
			$table->string('Note', 255);

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
