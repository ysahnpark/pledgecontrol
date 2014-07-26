
@section('content')
<form class="form-inline" role="form" mathod="GET" action="{{ URL::to(route('accounts.index')) }}">
  <div class="form-group">
    <label class="sr-only" for="name-like">Name</label>
    <input type="text" name="Name-like" class="form-control" id="Name" placeholder="Enter name" value="{{ $queryCtx->getQParamVal('Name-like') }}">
  </div>
  <button type="submit" class="btn btn-default">Search</button>
  <button id="btn_reset" class="btn btn-default">Reset</button>
</form>

<div class="pull-right"><a href="{{ URL::to(route('accounts.index')) }}?_format=xls&{{ $queryCtx->buildQueryString() }}">
	<span class="glyphicon glyphicon-download-alt"></span> XLS
	</a></div>
<table class="table table-striped">
	<thead> 
		<tr>
			<td>{{ Lang::get('account.Name') }}</td>
			<td>{{ Lang::get('account.PledgeAmount') }}</td>
			<td>{{ Lang::get('account.PledgeStartDate') }}</td>
			<td>{{ Lang::get('account.PaymentPeriod') }}</td>

			<td>{{ Lang::get('account.PeriodsPassed') }}</td>
			<td>{{ Lang::get('account.AmountDueNow') }}</td>
			<td><!-- CREATE ISSUE --></td>

			<td>{{ Lang::get('account.PaidAmount') }}</td>
			<td>{{ Lang::get('account.RemainingAmount') }}</td>
			<td>{{ Lang::get('account.ThankyouLetterSentDate') }}</td>
		</tr>
	</thead>
	<tbody> 
<?php
	$total_PledgeAmount = 0; 
	$total_AmountDueNow = 0;
	$total_PaidAmount = 0;
	$total_RemainingAmount = 0;
?>
@foreach ($records as $account)
<?php 
	$amountDueNow = ($account->PeriodsPassed * $account->AmountPerPeriod) - $account->PaidAmount ;
	$pastDueStyle = '';
	if ($amountDueNow > 1) {
		$pastDueStyle = 'style="color:red"';
	}
	$total_PledgeAmount += $account->PledgeAmount;
	$total_AmountDueNow += $amountDueNow;
	$total_PaidAmount += $account->PaidAmount;
	$total_RemainingAmount += $account->RemainingAmount;
?>
		<tr>
			<td><a href="{{ URL::to(route('accounts.show', array($account->ID))) }}">{{ $account->Name }}</a></td>
			<td class="col-amount" title="{{ \DocuFlow\Helper\DfFormat::currency($account->AmountPerPeriod) }}">{{ \DocuFlow\Helper\DfFormat::currency($account->PledgeAmount) }}</td>
			<td>{{ \DocuFlow\Helper\DfFormat::date($account->PledgeStartDate) }}</td>
			<td>{{ $account->PaymentPeriod }} {{ $account->PeriodUnit }} </td>
			
			<td>{{ $account->PeriodsPassed }}</td>
			
			<td class="col-amount" {{ $pastDueStyle}} >{{ \DocuFlow\Helper\DfFormat::currency( $amountDueNow ) }}</td>
			<td>@if ($amountDueNow > 1) 
				<?php 
				$category = 'OD';
				if ($account->PaidAmount == 0) {
					$category = 'FPR';
				}?>
				<a title="Create Issue Ticket" class="btn btn-warning" href="{{ URL::to(route('tickets.create', array('AccountID' => $account->ID, 'Category' => $category))) }}">I</a>
				@endif
			</td>

			<td class="col-amount" >{{ \DocuFlow\Helper\DfFormat::currency( $account->PaidAmount) }}</td>
			<td class="col-amount">{{ \DocuFlow\Helper\DfFormat::currency($account->RemainingAmount ) }}</td>
			<td>{{ \DocuFlow\Helper\DfFormat::date($account->ThankyouLetterSentDate) }}</td>
		</tr>
@endforeach

		<tr>
			<td>TOTALS</td>
			<td class="col-amount">{{ money_format('%(#10n', $total_PledgeAmount) }}</td>
			<td></td>
			<td></td>
			
			<td></td>
			
			<td class="col-amount" {{ $pastDueStyle}} >{{ money_format('%(#10n', $total_AmountDueNow ) }}</td>
			<td></td>

			<td class="col-amount">{{ money_format('%(#10n', $total_PaidAmount) }}</td>
			<td class="col-amount">{{ money_format('%(#10n', $total_RemainingAmount ) }}</td>
			<td></td>
		</tr>
	</tbody>
  <tfoot> 
    <tr>
      <td colspan="8"></td>
      </tr>    
  </tfoot> 
</table>

<script>
$(document).ready(function() {
	$('.page-header').append(' <a class="btn btn-small btn-info" href="{{ URL::to(route('accounts.create')) }}"><span class="glyphicon glyphicon-plus"></span> New</a>')
	$('#btn_reset').click(function() {
		$('#Name').val('');
	});
});
</script>


@show