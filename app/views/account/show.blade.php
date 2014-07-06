
<!-- app/views/account/edit.blade.php -->

@section('content')
<div class="container">

<!-- if there are creation errors, they will show here -->

<table>
	<tr>
		<td>{{ Lang::get('account.Name') }}</td>
		<td>{{ $record->Name }}</td>
	</tr>
	<tr>
		<td>{{ Lang::get('account.PledgeAmount') }}</td>
		<td>{{ $record->PledgeAmount }}</td>
	</tr>
	<tr>
		<td>{{ Lang::get('account.PledgeDate') }}</td>
		<td>{{ \DocuFlow\Helper\DfFormat::date($record->PledgeDate) }}</td>
	</tr>
	<tr>
		<td>{{ Lang::get('account.PaymentPeriod') }}</td>
		<td>{{ $record->PaymentPeriod }}</td>
	</tr>
	<tr>
		<td>{{ Lang::get('account.LastPaymentDate') }}</td>
		<td>{{ \DocuFlow\Helper\DfFormat::date($record->LastPaymentDate) }}</td>
	</tr>
	<tr>
		<td>{{ Lang::get('account.PaidAmount') }}</td>
		<td>{{ $record->PaidAmount }}</td>
	</tr>
	<tr>
		<td>{{ Lang::get('account.RemainingAmount') }}</td>
		<td>{{ $record->RemainingAmount }}</td>
	</tr>
	<tr>
		<td>{{ Lang::get('account.RemindLetterSent') }}</td>
		<td>{{ $record->RemindLetterSent }}</td>
	</tr>
	<tr>
		<td>{{ Lang::get('account.RemindLetterSentDate') }}</td>
		<td>{{ $record->RemindLetterSentDate }}</td>
	</tr>
</table>

<hr />
<h3>Transactions</h3>
<?php $transactions = $record->transactions; ?>

<table class="table table-striped">
	<thead> 
		<tr>
			<td class="col-date">Date</td>
			<td>Amount</td>
			<td>Note</td>
		</tr>
	</thead>
	<tbody> 
@foreach ($transactions as $transaction)
		<tr>
			<td>{{ \DocuFlow\Helper\DfFormat::date($transaction->PaymentDate) }}</td>
			<td>{{ $transaction->Amount }}</td>
			<td>{{ $transaction->Note }}</td>
		</tr>
@endforeach
	</tbody>
  <tfoot> 
    <tr>
      <td colspan="4">Pagination</td>
      </tr>    
  </tfoot> 
</table>

</div> <!-- container -->

<script>
$(document).ready(function() {
    $('.page-header').append(' <a title="Edit" href="{{ URL::to(route('accounts.edit', array($record->ID))) }}"><small><span class="glyphicon glyphicon-pencil"></span></small></a>')
} );
</script>

@show