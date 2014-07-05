<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('accounts', function(Blueprint $table)
		{
			$table->bigIncrements('ID');
			$table->string('Name', 128);
			$table->decimal('PledgeAmount', 10, 2);
			$table->dateTime('PledgeDate');
			$table->integer('PaymentPeriod');
			$table->dateTime('LastPaymentDate')->nullable();
			$table->decimal('PaidAmount', 10, 2);
			$table->decimal('RemainingAmount', 10, 2);
			$table->boolean('RemindLetterSent')->nullable();
			$table->dateTime('RemindLetterSentDate')->nullable();

			$table->string('Address', 255)->nullable();
			$table->string('City', 255)->nullable();
			$table->string('PostalCode', 255)->nullable();

			$table->index('Name');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('accounts');
	}

}
