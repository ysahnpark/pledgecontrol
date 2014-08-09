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
			$table->string('AccountNum')->nullable();
			$table->dateTime('SignupDate'); // Same as Signup Date
			$table->string('Name', 128);
			$table->dateTime('PledgeStartDate')->nullable(); // Pledge start 
			$table->decimal('PledgeAmount', 10, 2); 
			$table->integer('Duration')->nullable(); // Number of perdiod units in which this pledge ends
			$table->integer('PaymentPeriod')->nullable(); // Number of weeks or months interval for payment
			$table->string('PeriodUnit'); // 'w=week | m=month'
			$table->integer('SparePeriod')->default(0); // spare period, e.g. the partipant had certain circumstance and asked to sper a period 
			$table->decimal('AmountPerPeriod', 10, 2); // Calculated as (PledgeAmount / (Duration / PaymentPeriod))
			
			$table->decimal('PaidAmount', 10, 2); // calculated - Accumulated Payments
			$table->decimal('RemainingAmount', 10, 2); // calculated
			$table->bigInteger('LastTransactionID')->nullable(); // Derived
			$table->string('Status', 32); // Deriveved
			$table->dateTime('ThankyouLetterSentDate')->nullable();

			$table->string('Email', 255)->nullable();
			$table->string('Phone', 255)->nullable();
			$table->string('Address', 255)->nullable();
			$table->string('City', 255)->nullable();
			$table->string('State', 255)->nullable();
			$table->string('PostalCode', 255)->nullable();
			$table->mediumText('Note')->nullable();

			$table->index('Name');
			$table->unique('Email');
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
