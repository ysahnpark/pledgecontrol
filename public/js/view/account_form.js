
	function parsePaymentCycle()
	{
		var cycle = $('#PaymentCycle').val();
		var tokens = cycle.split('-');
		$('#PeriodUnit').val(tokens[0]);
		$('#PaymentPeriod').val(tokens[1]);
	}

	function calcAmountPerPeriod()
	{
		var pledgeAmount = $('#PledgeAmount').val();
		var duration = $('#Duration').val();
		var paymentPeriod = $('#PaymentPeriod').val();

		if (pledgeAmount && duration && paymentPeriod) {
			var amountPerPeriod = pledgeAmount / (duration / paymentPeriod);
			$('#AmountPerPeriod').val(amountPerPeriod.toFixed(2));
		}
	}