<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tickets', function(Blueprint $table)
		{
			$table->bigIncrements('ID');
			$table->dateTime('TicketDate');
			$table->bigInteger('AccountID');
			$table->string('HandledBy', 128)->nullable();
			$table->string('Category', 12); // "FPR = First payment request", "OD = Overdue"
			$table->mediumText('Description', 64)->nullable();
			$table->string('Status', 32); // "Created, Notified, Resolved, Dropped"
			$table->mediumText('Log')->nullable(); // "Follow-up"
			$table->mediumText('Result')->nullable(); // "Result"
			$table->dateTime('NotificationDate')->nullable();
			$table->dateTime('CompletionDate')->nullable();
			$table->string('Note', 255)->nullable();

			$table->index('AccountID');
			$table->index('Category');
			$table->index('Status');
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
		Schema::dropIfExists('tickets');
	}

}
