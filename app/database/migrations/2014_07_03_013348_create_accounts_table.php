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
			$table->dateTime('CreateDate');
			$table->string('Name', 128);
			$table->dateTime('PledgeDate'); // Pledge start 
			$table->decimal('PledgeAmount', 10, 2); 
			$table->integer('Duration'); // Number of perdiod units in which this pledge ends
			$table->integer('PaymentPeriod');
			$table->string('PeriodUnit'); // 'w=week | m=month'
			$table->decimal('AmountPerPeriod', 10, 2);
			$table->decimal('PaidAmount', 10, 2);
			$table->decimal('RemainingAmount', 10, 2);
			$table->dateTime('LastTransactionID')->nullable();
			$table->string('Status');
			$table->dateTime('ThankyouLetterSentDate')->nullable();

			$table->string('Email', 255)->nullable();
			$table->string('Phone', 255)->nullable();
			$table->string('Address', 255)->nullable();
			$table->string('City', 255)->nullable();
			$table->string('State', 255)->nullable();
			$table->string('PostalCode', 255)->nullable();
			$table->mediumText('Note')->nullable();

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
